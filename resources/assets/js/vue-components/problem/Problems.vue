<template>
	<div class="row justify-content-center py-5">
		<div class="col-12 col-md-10 col-lg-11 col-xl-9">
			<div class="container-fluid p-0">
				<div class="row" v-if="errorMessage.length">
					<div class="col">
						<div class="alert-component position-relative d-none" id="errorAlert">
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
					<li v-for="problem in problems" :key="problem.id" class="col-12 col-sm-6 col-md-6 col-lg-4">
						<a class="card-link" :href="getProblemPageURL(problem)">
							<div class="card">
								<div v-if="!problem.img_url" class="card-placeholder-img-container">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 144 92"
										width="144"
										height="92"
									>
										<!-- SVG content here -->
									</svg>
								</div>
								<div v-else class="card-custom-img-container">
									<img :src="problem.img_url" alt="Card image cap" width="282" height="180" />
								</div>
								<div class="card-body">
									<h5 class="card-title">
										{{ problem.currentTranslation.title }}
									</h5>
									<p class="card-text mb-4">
										{{ problem.currentTranslation.description }}
									</p>
								</div>
							</div>
						</a>
						<ShareCircleButton
							:icon-color-theme="buttonTextColorTheme"
							:share-url="getProblemPageURL(problem)"
						></ShareCircleButton>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from "vuex";
import ShareCircleButton from "../common/ShareCircleButton.vue";
import { getLocale } from "../../common-utils";

export default {
	name: "Problems",
	components: {
		ShareCircleButton,
	},
	props: {
		projectId: {
			type: Number,
			required: true,
		},
		projectSlug: {
			type: String,
			required: true,
		},
		buttonTextColorTheme: {
			type: String,
			default: "light",
		},
	},
	data() {
		return {
			problems: [],
			loading: true,
			error: null,
			errorMessage: "",
		};
	},
	methods: {
		...mapActions(["get"]),
		async fetchProblems() {
			this.loading = true;
			this.errorMessage = "";
			return this.get({
				url: window.route("api.problems.get") + `?projectId=${this.projectId}`,
				urlRelative: false,
			})
				.then((response) => {
					this.problems = response.data;
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
			const alertElement = document.querySelector("#errorAlert");
			alertElement.classList.remove("d-none");
			setTimeout(() => {
				alertElement.classList.add("d-none");
			}, 5000);
		},
		getProblemPageURL(problem) {
			return window.route("problem.show", getLocale(), this.projectSlug, problem.slug);
		},
	},
	watch: {
		projectId: "fetchProblems",
	},
	mounted() {
		console.log("mounted");
		this.fetchProblems();
	},
};
</script>

<style scoped lang="scss">
ul {
	list-style-type: none;
}

h2 {
	font-weight: bold;
	margin-top: 2rem;
	margin-bottom: 2rem;
}

.card {
	border: none;
	box-shadow: 0 4px 4px 0 #00000040;

	&:hover {
		box-shadow:
			0 4px 4px 0 #00000040,
			0 4px 4px 0 #00000040;

		svg {
			color: var(--project-primary-color);
		}
	}
}

a.card-link {
	display: block;
	border-radius: 1rem;

	&:hover {
		color: unset;
	}

	&:focus-visible {
		border-radius: 1rem;
		outline: 4px solid black; // bookmark1 - calculate in rem
	}
}

.card {
	border-radius: 1rem;
	margin-bottom: 2rem;
	overflow: clip;
}

.card-placeholder-img-container {
	background-color: var(--clr-secondary-grey);
	padding-top: 4.3rem;
	padding-bottom: 2.2rem;
	height: 180px;

	svg {
		width: 100%;
		color: var(--clr-secondary-light-grey);
	}
}

.card-custom-img-container {
	background-color: var(--clr-secondary-grey);
	height: 180px;

	img {
		width: 100%;
		object-fit: cover;
	}
}

.card-body {
	background-color: var(--clr-secondary-light-grey);

	.card-title {
		font-family: "Noto Sans Variable", sans-serif;
		font-weight: 500;
		font-size: 24px; // 24px // bookmark1 - calulate in rem
		line-height: 29.34px; // 29.34px // bookmark1 - calulate in rem

		// truncate at 2 lines
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		line-clamp: 2;
		overflow: clip;
		height: 2lh;
	}

	.card-text {
		font-family: "Open Sans Variable", sans-serif;
		font-weight: 400;
		font-size: 16px; // 16px // bookmark1 - calulate in rem
		line-height: 20.4px; // 20.4px // bookmark1 - calulate in rem

		// truncate at 4 lines
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 4;
		line-clamp: 4;
		overflow: clip;
		height: 4lh;
	}
}

// from "md" and UP
@media (min-width: 768px) {
	h2 {
		margin-top: 7.5rem;
	}
}

// from "xs" and DOWN
@media (max-width: 575.98px) {
	ul {
		display: block;
	}
	li {
		width: 22.8rem;
		margin: 0 auto;
	}
}
</style>
