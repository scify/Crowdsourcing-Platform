<template>
	<div class="py-4">
		<propose-solution></propose-solution>
		<div class="row">
			<div class="col-12">
				<h2 class="my-2">{{ trans("project-problems.list_of_solutions") }}</h2>
			</div>
		</div>
		<div class="row justify-content-center py-5">
			<div class="col-12 col-md-10 col-lg-11 col-xl-9">
				<div class="container-fluid p-0">
					<div class="row pb-4" v-if="userVotesLeft !== null">
						<div class="col">
							<p style="font-size: 1.429rem; line-height: 1.949rem; text-align: center; margin-bottom: 0">
								You can vote for up to {{ maxVotesPerUserForSolutions }} solutions in total.
								<!-- bookmark4 - how to translate with dynamic fields? -->
								You have {{ userVotesLeft }} more votes remaining.
							</p>
						</div>
					</div>
					<div class="row" v-if="errorMessage.length">
						<div class="col">
							<div class="alert-component position-relative d-none" id="error-alert">
								<div class="alert alert-danger" role="alert">
									{{ errorMessage }}
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
						<!-- <li v-for="solution in solutions" :key="solution.id" class="col-12 col-sm-6 col-md-6 col-lg-4"> -->
						<li
							v-for="solution in solutions"
							:key="solution.id"
							class="col-12"
							:id="'solution_card_' + solution.id"
						>
							<div class="card">
								<div v-if="!solution.img_url" class="card-placeholder-img-container">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 138 112"
										width="138"
										height="112"
									>
										<path
											d="M45.3991 25.3996C42.7991 15.3996 35.3991 6.89959 24.7991 5.49959C14.1991 4.09959 15.3991 5.59959 11.4991 8.29959C7.59908 10.9996 5.19908 14.3996 3.39908 18.2996C-0.30092 26.4996 -1.20092 36.8996 1.79908 45.5996C5.09908 55.2996 13.2991 61.4996 22.0991 65.9996C28.1991 69.0996 34.4991 71.7996 40.4991 74.8996C46.4991 77.9996 54.0991 82.3996 60.7991 86.3996C61.298 86.6975 61.8991 86.1996 61.6991 85.6996C60.4991 81.4996 57.6991 78.1996 55.7991 74.3996C53.8991 70.5996 54.3991 71.0996 55.0991 69.3996C55.7991 67.6996 58.6991 66.1996 60.5991 65.1996C64.6991 62.9996 68.8991 60.6996 72.3991 57.5996C75.8991 54.4996 79.4991 49.8996 82.0991 45.3996C86.9991 36.7996 88.6991 26.3996 83.3991 17.5996C81.2991 14.0996 78.3991 10.7996 74.4991 9.19959C70.5991 7.59959 67.7991 7.79959 64.3991 8.39959C55.3991 10.0996 47.6991 16.8996 44.0991 25.1996C44.3381 26.3283 44.999 26.5 45.1991 25.7996C48.3991 18.3996 54.7991 12.2996 62.5991 9.99959C65.8991 8.99959 69.5991 8.79959 72.8991 9.89959C76.1991 10.9996 79.7991 14.3996 81.9991 17.7996C87.5991 26.6996 85.3991 37.1996 80.2991 45.6996C75.1991 54.1996 74.4991 54.1996 70.4991 57.3996C66.4991 60.5996 62.4991 62.5996 58.3991 64.7996C54.2991 66.9996 54.4991 66.9996 53.6991 68.9996C52.8991 70.9996 53.3991 72.1996 53.9991 73.6996C55.6991 77.9996 58.9991 81.3996 60.2991 85.8996L61.1991 85.1996C50.3991 78.6996 39.3991 72.5996 27.8991 67.3996C19.1991 63.3996 10.0991 58.6996 5.09908 50.1996C0.59908 42.3996 0.39908 32.2996 2.79908 23.4996C5.19908 15.2996 10.6991 7.39959 19.8991 6.59959C29.0991 5.79959 31.2991 7.89959 35.6991 11.5996C40.0991 15.2996 42.7991 20.2996 44.1991 25.7996C44.499 27 45.5991 26.1996 45.3991 25.4996V25.3996Z"
											fill="currentColor"
										/>
										<path
											d="M25.1006 14.5996C14.0006 15.3996 6.80057 29.3996 11.2006 39.1996C15.6006 48.9996 12.6006 39.1996 12.3006 38.5996C8.30057 29.5996 15.0006 16.5996 25.1006 15.8996C35.2006 15.1996 25.9006 14.5996 25.1006 14.6996V14.5996Z"
											fill="currentColor"
										/>
										<path
											d="M47.4004 15.2V1.2C47.4004 -0.4 44.9004 -0.4 44.9004 1.2V15.2C44.9004 16.8 47.4004 16.8 47.4004 15.2Z"
											fill="currentColor"
										/>
										<path
											d="M51.3001 11.7998C53.2001 9.8998 55.1001 7.9998 57.0001 6.0998C58.9001 4.1998 57.5001 4.7998 57.0001 4.2998C56.5001 3.7998 55.7001 3.7998 55.2001 4.2998C53.3001 6.1998 51.4001 8.0998 49.5001 9.9998C47.6001 11.8998 49.0001 11.2998 49.5001 11.7998C50.0001 12.2998 50.8001 12.2998 51.3001 11.7998Z"
											fill="currentColor"
										/>
										<path
											d="M42.1992 10.0999C40.2992 8.19991 38.3992 6.19991 36.4992 4.29991C34.5992 2.39991 35.1992 3.79991 34.6992 4.29991C34.1992 4.79991 34.1992 5.59991 34.6992 6.09991C36.5992 7.99991 38.4992 9.99991 40.3992 11.8999C42.2992 13.7999 41.6992 12.3999 42.1992 11.8999C42.6992 11.3999 42.6992 10.5999 42.1992 10.0999Z"
											fill="currentColor"
										/>
										<path
											d="M95.1999 66.5999C96.3999 64.1999 97.4999 61.7999 98.6999 59.3999C99.8999 56.9999 101.2 54.1999 103.3 52.4999C106.7 49.4999 109.8 58.0999 110.7 60.1999C111.6 62.2999 112.3 64.5999 112.9 66.7999C113.086 67.4807 113.3 67.2999 113.7 67.1999C116.2 66.4999 118.6 65.2999 121 64.1999C123.4 63.0999 126.4 61.6999 129.3 61.6999C135.3 61.5999 129 70.4999 127.7 72.3999C126.4 74.2999 124.7 76.2999 123.6 78.4999C123.5 79 123.5 79.0999 123.6 79.2999C126.8 82.0999 131 83.9999 133.5 87.4999C136 90.9999 135 90.9999 132.9 91.5999C130.8 92.1999 127.8 91.7999 125.4 91.5999C123 91.3999 120.2 90.7999 117.7 90.5999C117.283 90.5999 117.1 90.7999 117.1 91.0999C116.6 93.6999 116.9 96.3999 117 99.0999C117.1 101.8 117 105.4 115 107.5C111.7 110.9 106.8 103.9 105.1 101.7C103.4 99.4999 102.3 97.7999 100.6 96.0999C100.3 95.7999 99.9999 95.8999 99.6999 96.0999C98.2999 97.1999 97.1999 98.5999 95.9999 99.8999C94.7999 101.2 92.7999 103.5 91.0999 105.1C89.3999 106.7 88.1999 107.9 86.3999 108C84.5999 108.1 83.5999 104 83.5999 102.3C83.5999 98.3999 84.8999 94.5999 85.9999 90.8999C86.2377 90.0999 85.7999 90.0999 85.3999 90.0999C82.7999 89.8999 80.2999 89.4999 77.7999 88.7999C75.2999 88.0999 72.3999 87.3999 70.5999 85.4999C66.8999 81.6999 76.3999 78.6999 78.6999 77.8999C80.9999 77.0999 82.9999 76.6999 85.1999 76.1999C86 76 85.7999 75.4999 85.4999 75.1999C83.2999 72.5999 81.2999 69.7999 79.3999 66.8999C77.4999 63.9999 77.8999 64.3999 77.1999 62.9999C76.4999 61.5999 76.3999 61.4999 76.5999 60.7999C77.1999 59.2999 80.3999 60.2999 81.3999 60.5999C83.8999 61.2999 86.2999 62.2999 88.5999 63.3999C90.8999 64.4999 92.5999 65.2999 94.0999 66.6999C95 67.5 95.5999 66.2999 94.9999 65.7999C93.3999 64.3999 91.2999 63.3999 89.3999 62.4999C87.4999 61.5999 83.9999 59.9999 81.1999 59.2999C78.3999 58.5999 76.9999 58.2999 75.6999 59.7999C74.3999 61.2999 76.0999 63.9999 76.8999 65.4999C78.9999 69.2999 81.5999 72.8999 84.3999 76.0999L84.6999 75.0999C82.4999 75.5999 80.2999 76.1999 78.0999 76.8999C75.8999 77.5999 72.5999 78.6999 70.3999 80.4999C68.1999 82.2999 67.6999 83.4999 68.6999 85.4999C69.6999 87.4999 72.8999 88.7999 75.1999 89.5999C77.4999 90.3999 81.7999 91.1999 85.1999 91.4999L84.5999 90.6999C83.5999 94.3999 82.2999 97.9999 82.1999 101.9C82.0999 105.8 82.4999 107.9 84.7999 109.1C87.0999 110.3 88.3999 108.8 89.6999 107.8C91.7999 106.3 93.5999 104.4 95.2999 102.4C96.9999 100.4 98.3999 98.5999 100.3 96.9999H99.3999C102.9 100.5 105.2 105.3 109.3 108.3C113.4 111.3 112.9 110.3 114.7 109.2C116.5 108.1 117.7 104.8 117.9 102.3C118.2 98.6999 117.4 94.9999 118 91.4999L117.4 91.9999C120 92.1999 122.6 92.6999 125.1 92.9999C127.6 93.2999 130.7 93.6999 133.2 92.9999C135.7 92.2999 135.8 90.4999 135.2 88.7999C134.6 87.0999 132.3 84.7999 130.4 83.2999C128.5 81.7999 126.1 80.3999 124.2 78.6999V79.4999C125.4 77.3999 127 75.4999 128.3 73.4999C129.6 71.4999 131.7 68.4999 132.5 65.6999C133.3 62.8999 132.8 61.7999 130.7 60.9999C128.6 60.1999 125 61.3999 122.7 62.2999C120.4 63.1999 116.4 65.3999 113 66.1999L113.8 66.5999C112.5 61.9999 110.9 56.7999 107.9 52.8999C104.9 48.9999 105.3 50.0999 103.5 50.7999C101.7 51.4999 99.5999 54.6999 98.4999 56.6999C96.7999 59.7999 95.3999 62.9999 93.7999 66.0999C93.6816 66.329 94.4999 67.3999 94.8999 66.6999L95.1999 66.5999Z"
											fill="currentColor"
										/>
										<path
											d="M119.299 68.9999C121.199 67.8999 123.199 66.8999 125.299 65.9999C127.399 65.0999 125.699 65.3999 125.499 65.0999C125.299 64.7999 124.999 64.7 124.599 64.9C122.499 65.8 120.499 66.8 118.599 67.9C116.699 69 118.599 69.3999 119.199 68.9999H119.299Z"
											fill="currentColor"
										/>
										<path
											d="M86.6996 95.6002C86.3996 97.2002 86.3996 98.9002 86.1996 100.5C85.9996 102.1 86.1996 101.2 86.5996 101.3C86.9996 101.4 87.2996 101.2 87.3996 100.9C87.6996 99.3002 87.6996 97.6002 87.8996 96.0002C88.0996 94.4002 87.8996 95.3002 87.4996 95.2002C87.0996 95.1002 86.7996 95.3002 86.6996 95.6002Z"
											fill="currentColor"
										/>
										<path
											d="M81.3005 63.5999C84.1005 64.9999 86.9005 66.0999 89.9005 66.8999C92.9005 67.6999 91.0005 65.8999 90.2005 65.6999C87.3005 64.8999 84.6005 63.7999 81.9005 62.4999C79.2005 61.1999 80.5005 63.1999 81.3005 63.5999Z"
											fill="currentColor"
										/>
										<path
											d="M112.6 94.8995C112.6 97.5995 112.3 100.3 112.9 103C113.5 105.7 114.3 103.5 114.1 102.7C113.6 100.2 113.8 97.4995 113.9 94.9995C114 92.4995 112.7 94.1995 112.7 94.9995L112.6 94.8995Z"
											fill="currentColor"
										/>
										<path
											d="M122.701 84.5998C124.601 85.9998 126.901 86.7998 129.001 87.8998C131.101 88.9998 130.401 87.1998 129.601 86.7998C127.501 85.6998 125.301 84.8998 123.301 83.4998C121.301 82.0998 122.601 83.4998 122.401 83.6998C122.201 83.8998 122.401 84.3998 122.601 84.5998H122.701Z"
											fill="currentColor"
										/>
										<path
											d="M76.1995 83.7001C77.7995 82.6001 79.6995 82.1001 81.3995 81.2001C83.0995 80.3001 81.7995 80.6001 81.5995 80.3001C81.3995 80.0001 80.9995 79.9001 80.6995 80.1001C78.9995 80.9001 77.0995 81.5001 75.4995 82.6001C73.8995 83.7001 75.0995 83.2001 75.2995 83.5001C75.4995 83.8001 75.8995 83.9001 76.1995 83.7001Z"
											fill="currentColor"
										/>
										<path
											d="M104.7 58.2995C105.3 59.9995 106.2 61.4995 106.9 63.0995C107.6 64.6995 107.5 63.4995 107.8 63.2995C108.1 63.0995 108.2 62.6995 108 62.3995C107.3 60.8995 106.4 59.4995 105.9 57.8995C105.4 56.2995 105.5 57.3995 105.1 57.4995C104.7 57.5995 104.6 57.8995 104.7 58.2995Z"
											fill="currentColor"
										/>
									</svg>
								</div>
								<div v-else class="card-custom-img-container">
									<img
										:src="solution.img_url"
										alt="decorative image for solution"
										width="282"
										height="180"
									/>
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
								@click="heartClicked(solution.id)"
							></HeartCircleButton>
							<div class="upvote-count" :style="{ backgroundColor: rgbaColor('#000000', 0.65) }">
								{{ solution.upvotes_count }}
							</div>
							<div>
								<!-- bookmark4 - this div was created to "comment out" the encapsulated content without it being visible in the final markup-->
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
</template>

<script>
import { mapActions } from "vuex";
import ShareCircleButton from "../common/ShareCircleButton.vue";
import HeartCircleButton from "../common/HeartCircleButton.vue";
import ProposeSolution from "./ProposeSolution.vue";

export default {
	name: "Solutions",
	components: {
		ProposeSolution,
		ShareCircleButton,
		HeartCircleButton,
	},
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

	methods: {
		...mapActions(["get", "post"]),
		rgbaColor(hexColor, alpha = 0.8) {
			const hex = hexColor.replace("#", "");
			const r = parseInt(hex.substring(0, 2), 16);
			const g = parseInt(hex.substring(2, 4), 16);
			const b = parseInt(hex.substring(4, 6), 16);
			return `rgba(${r}, ${g}, ${b}, ${alpha})`;
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
					this.showErrorMessage(error); // bookmark4
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
			const alertElement = document.querySelector("#error-alert");
			alertElement.classList.remove("d-none");
			setTimeout(() => {
				alertElement.classList.add("d-none");
			}, 5000);
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
		heartClicked(solutionId) {
			if (this.votingInProgress) {
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
					this.showErrorMessage(error); // bookmark4
				})
				.finally(() => {
					this.votingInProgress = false;
				});
			this.updateUpvotesClientSide(solutionId);
		},
		postSolutionShare(solutionId) {
			this.post({
				url: window.route("api.solutions.handle-share"),
				data: { solution_id: solutionId },
				urlRelative: false,
			})
				.then((response) => {})
				.catch((error) => {
					this.showErrorMessage(error); // bookmark4
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
</style>
