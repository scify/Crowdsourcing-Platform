<template>
	<div class="py-4">
		<propose-solution></propose-solution>
		<div class="row">
			<div class="col-12">
				<h2 class="my-2">{{ trans("project-problems.list_of_solutions") }}</h2>
			</div>
		</div>
		<div class="row justify-content-center py-5">
			<div class="col-lg-12 col-md-10 col-lg-11 col-xl-9">
				<div class="container-fluid p-0">
					<div v-if="userVotesLeft !== null" class="row pb-4">
						<div class="col">
							<p
								v-sane-html="getVotesInfoMessage()"
								style="font-size: 1.429rem; line-height: 1.949rem; text-align: center; margin-bottom: 0"
							></p>
							<p
								v-sane-html="getVotesLeftMessage()"
								style="font-size: 1.429rem; line-height: 1.949rem; text-align: center"
							></p>
						</div>
					</div>
					<div v-if="errorMessage.length" class="row">
						<div class="col">
							<div id="error-alert" class="alert-component position-relative d-none">
								<div class="alert alert-danger" role="alert">
									<p v-sane-html="errorMessage" class="my-2"></p>
								</div>
							</div>
						</div>
					</div>
					<div v-if="loading" class="row">
						<div class="col mx-auto">
							<div class="d-flex justify-content-center align-items-center">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>
					</div>
					<ul class="row">
						<li
							v-for="solution in solutions"
							:id="'solution_card_' + solution.id"
							:key="solution.id"
							class="col-12"
						>
							<div class="card">
								<div v-if="!solution.img_url" class="card-placeholder-img-container">
									<SolutionDefaultImage></SolutionDefaultImage>
								</div>
								<div v-else class="card-custom-img-container">
									<img :src="solution.img_url" alt="decorative image for solution" />
								</div>
								<div class="card-body">
									<h5 class="card-title">
										{{ solution.current_translation.title }}
									</h5>
									<p class="card-text mb-4">
										{{ solution.current_translation.description }}
									</p>
								</div>
							</div>
							<HeartCircleButton
								:is-filled="solution.upvoted_by_current_user"
								:solution-id="solution.id"
								:icon-color-theme="buttonTextColorTheme"
								@click="(event) => heartClicked(event, solution.id)"
							></HeartCircleButton>
							<div class="upvote-count" :style="{ backgroundColor: rgbaColor('#000000', 0.65) }">
								{{ solution.upvotes_count }}
							</div>
							<div>
								<ShareCircleButton
									:icon-color-theme="buttonTextColorTheme"
									:share-url="getSolutionPageURL(solution)"
								></ShareCircleButton>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div v-if="solutions.length > 10">
			<propose-solution></propose-solution>
		</div>
	</div>
	<div ref="loginPanel" class="floating-panel d-none">
		<div class="panel-header">
			<p v-sane-html="trans('voting.vote_login_message')"></p>
			<button class="close-btn" @click="hideLoginPanel">&times;</button>
		</div>
		<button class="main-btn btn btn-slim" @click="redirectToLogin">
			{{ trans("questionnaire.sign_in")}}
		</button>
	</div>
</template>

<script>
import { mapActions } from "vuex";
import ShareCircleButton from "../common/ShareCircleButton.vue";
import HeartCircleButton from "../common/HeartCircleButton.vue";
import ProposeSolution from "./ProposeSolution.vue";
import transMixin from "../../vue-mixins/trans-mixin";
import { showToast } from "../../common-utils";
import SolutionDefaultImage from "./SolutionDefaultImage.vue";

export default {
	name: "Solutions",
	components: {
		SolutionDefaultImage,
		ProposeSolution,
		ShareCircleButton,
		HeartCircleButton,
	},
	mixins: [transMixin],
	props: {
		problemId: {
			type: Number,
			required: true,
		},
		problemSlug: {
			type: String,
			required: true,
		},
		projectSlug: {
			type: String,
			required: true,
		},
		maxVotesPerUserForSolutions: {
			type: Number,
			required: true,
		},
		buttonTextColorTheme: {
			type: String,
			default: "light",
		},
		projectPrimaryColor: {
			type: String,
			default: "#000000",
		},
		userLoggedIn: {
			type: Boolean,
			required: true,
			default: false,
		},
	},
	data() {
		return {
			solutions: [],
			loading: true,
			error: null,
			errorMessage: "",
			userAlreadyCastVotes: null,
			userVotesLeft: null,
			votingInProgress: false,
		};
	},
	computed: {
		buttonTextColor() {
			return this.buttonTextColorTheme === 'dark' ? '#000000' : '#ffffff';
		}
	},
	methods: {
		...mapActions(["get", "post"]),
		rgbaColor(hexColor, alpha = 0.8) {
			const hex = hexColor.replace("#", "");
			const r = parseInt(hex.substring(0, 2), 16);
			const g = parseInt(hex.substring(2, 4), 16);
			const b = parseInt(hex.substring(4, 6), 16);
			return `rgba(${r}, ${g}, ${b}, ${alpha})`;
		},
		getVotesInfoMessage() {
			return trans("voting.you_can_vote_up_to", {
				votes: this.maxVotesPerUserForSolutions,
				entityName: trans("voting.entity_solutions"),
			});
		},
		getVotesLeftMessage() {
			return trans("voting.votes_remaining", {
				votes: this.userVotesLeft,
				votesWord:
					this.userVotesLeft === 1
						? trans("voting.votes_remaining_singular")
						: trans("voting.votes_remaining_plural"),
			});
		},
		async fetchSolutions() {
			this.loading = true;
			this.errorMessage = "";
			return this.get({
				url: window.route("api.solutions.get") + `?problem_id=${this.problemId}`,
				urlRelative: false,
			})
				.then((response) => {
					this.solutions = response.data.solutions;
					this.userAlreadyCastVotes = response.data.user_votes;
					this.userVotesLeft = this.maxVotesPerUserForSolutions - this.userAlreadyCastVotes;
					this.checkSolutionInURLAndHighlight();
				})
				.catch((error) => {
					this.showErrorMessage(error);
				})
				.finally(() => {
					this.loading = false;
				});
		},
		showErrorMessage(error) {
			// first check if the error message is just a string
			if (typeof error === "string") {
				this.errorMessage = error;
			} else if (error.response && error.response.data && error.response.data.message) {
				this.errorMessage = error.response.data.message;
			} else {
				this.errorMessage = `An error occurred. Please try again later. Error: ${error}`;
			}
			this.$nextTick(() => {
				const alertElement = document.querySelector("#error-alert");
				alertElement.classList.remove("d-none");
				setTimeout(() => {
					alertElement.classList.add("d-none");
				}, 5000);
			});
		},
		checkSolutionInURLAndHighlight() {
			const urlParams = new URLSearchParams(window.location.search);
			const solutionId = urlParams.get("solution_id");
			if (solutionId) {
				// put the solution with the given ID at the top of the list
				const solution = this.solutions.filter((solution) => {
					return solution.id === parseInt(solutionId);
				})[0];
				if (solution) {
					this.solutions = this.solutions.filter((s) => {
						return s.id !== solution.id;
					});
					this.solutions.unshift(solution);
				}
				// Wait for the DOM to update
				this.$nextTick(() => {
					// add a "highlight" class to the solution card (card with the given solution_id as "solution_card_" id)
					const solutionCard = document.getElementById(`solution_card_${solutionId}`);
					if (solutionCard) {
						solutionCard.classList.add("highlighted");
					}
					// scroll to the solution card
					solutionCard.scrollIntoView({ behavior: "smooth" });
				});
				// remove the solution_id from the URL
				const newURL = window.location.href.split("?")[0];
				window.history.replaceState({}, document.title, newURL);
				this.postSolutionShare(solutionId);
			}
		},
		getSolutionPageURL(solution) {
			// get the current URL, with a ?solution_id= appended to it
			return `${window.location.href}?solution_id=${solution.id}`;
		},
		heartClicked(event, solutionId) {
			if (!this.userLoggedIn) {
				this.showLoginPanel(event.clientX, event.clientY);
				return;
			}
			if (this.votingInProgress) {
				return;
			}
			if (this.userVotesLeft <= 0) {
				showToast(
					trans("voting.votes_remaining", {
						votes: 0,
						votesWord: trans("voting.votes_remaining_plural"),
					}),
					"#dc3545",
					"bottom-right",
				);
				return;
			}
			this.votingInProgress = true;
			this.errorMessage = "";
			this.post({
				url: window.route("api.solutions.vote-downvote"),
				data: { solution_id: solutionId },
				urlRelative: false,
			})
				.then((response) => {})
				.catch((error) => {
					this.showErrorMessage(error);
				})
				.finally(() => {
					this.votingInProgress = false;
				});
			this.updateUpvotesClientSide(solutionId);
		},
		showLoginPanel(x, y) {
			console.log("showing login panel", this.$refs.loginPanel);
			if (this.$refs.loginPanel) {
				x += 40;
				y += 10;
				this.$refs.loginPanel.style.left = `${x}px`;
				this.$refs.loginPanel.style.top = `${y}px`;
				this.$refs.loginPanel.classList.remove("d-none");
				this.$refs.loginPanel.classList.add("visible");
			}
		},
		hideLoginPanel() {
			if (this.$refs.loginPanel) {
				this.$refs.loginPanel.classList.remove("visible");
				setTimeout(() => {
					this.$refs.loginPanel.classList.add("d-none");
				}, 300);
				document.removeEventListener("click", this.handleOutsideClick);
				window.removeEventListener("scroll", this.hideLoginPanel);
			}
		},
		handleOutsideClick(event) {
			if (this.$refs.loginPanel && !this.$refs.loginPanel.contains(event.target)) {
				this.hideLoginPanel();
			}
		},
		redirectToLogin() {
			window.location.href = window.route("login", window.Laravel.locale) + "?redirectTo=" + window.location.href;
		},
		postSolutionShare(solutionId) {
			this.post({
				url: window.route("api.solutions.handle-share"),
				data: { solution_id: solutionId },
				urlRelative: false,
			})
				.then((response) => {})
				.catch((error) => {
					this.showErrorMessage(error);
				});
		},
		updateUpvotesClientSide(solutionId) {
			const solution = this.solutions.filter((solution) => {
				return solution.id === solutionId;
			})[0];
			const wasUpvoted = solution.upvoted_by_current_user;
			solution.upvoted_by_current_user = !solution.upvoted_by_current_user;
			if (wasUpvoted) {
				solution.upvotes_count -= 1;
				this.userVotesLeft += 1;
			} else {
				solution.upvotes_count += 1;
				this.userVotesLeft -= 1;
			}
		},
		trans(key) {
			return window.trans(key);
		},
	},
	watch: {
		problemId: "fetchSolutions",
	},
	mounted() {
		this.fetchSolutions();
	},
};
</script>

<style scoped lang="scss">
@import "../../../sass/solution/solutions-list";
:root {
	--button-text-color-theme: #{buttonTextColor};
}
</style>
