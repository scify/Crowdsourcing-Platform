<template>
	<div class="row justify-content-center py-5">
		<div class="col-lg-12 col-md-10 col-lg-11 col-xl-9">
			<div class="container-fluid p-0">
				<div v-if="errorMessage.length" class="row">
					<div class="col">
						<div id="errorAlert" class="alert-component position-relative d-none">
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
					<li v-for="problem in problems" :key="problem.id" class="col-12 col-sm-12 col-md-6 col-lg-6">
						<a class="card-link" :href="getProblemPageURL(problem)">
							<div class="card">
								<div v-if="!problem.img_url" class="card-placeholder-img-container">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 144 92"
										width="144"
										height="92"
									>
										<path
											fill="currentColor"
											d="M76.333 2.501c3.271-.751 6.943-.144 9.319 2.371 1.048 1.102 1.792 2.531 1.96 4.056.2 1.868-.28 3.736.032 5.604.072.455.2.926.552 1.246.376.335.888.367 1.368.303 1.096-.152 2.184-.367 3.28-.551.76-.128.44-1.285-.32-1.157l-2.96.503c-.344.056-.584.111-.68-.264-.12-.455-.144-.934-.152-1.405-.032-1.812.344-3.617-.104-5.405-.784-3.169-3.488-5.565-6.584-6.403-1.968-.535-4.048-.503-6.023-.048-.752.176-.432 1.326.32 1.158l-.008-.008Zm-62.75 10.546c-2.239.287-4.287 1.373-5.839 3.01-1.672 1.756-2.688 4.047-3.072 6.427a16.6 16.6 0 0 0-.112 4.271c.032.319.256.599.6.599s.632-.272.6-.599c-.44-4.295.832-9.014 4.712-11.393.944-.575 2.008-.99 3.103-1.126.32-.039.6-.247.6-.598 0-.352-.28-.639-.6-.599l.008.008Zm36.455 60.364c.704-.295 1.464-.623 2.24-.607.704.016 1.248.439 1.624 1.014.84 1.294.984 2.882 1.352 4.351.32 1.294.856 2.667 1.896 3.553 1.232 1.054 2.88 1.19 4.44 1.325 2 .176 4.008.216 6.015.112.768-.04.776-1.237 0-1.197a44.88 44.88 0 0 1-5.391-.056c-1.44-.112-3.272-.112-4.384-1.182-1-.966-1.328-2.411-1.608-3.72-.32-1.501-.64-3.09-1.664-4.295a3.067 3.067 0 0 0-2.144-1.086c-.936-.064-1.848.287-2.696.638-.296.128-.512.4-.416.735.08.279.44.543.736.415Zm89.29-11.057c0 5.733 0 11.952-3.064 17.029-.759 1.262-1.735 2.587-3.247 2.93-.752.168-.432 1.326.32 1.158 1.472-.335 2.56-1.421 3.407-2.611.888-1.253 1.56-2.65 2.088-4.087 1.064-2.906 1.456-6.028 1.608-9.102.088-1.772.096-3.544.096-5.317 0-.774-1.2-.774-1.2 0h-.008Zm-7.407-39.527c2.255.392 4.519 1.206 6.167 2.851 1.728 1.732 2.464 4.199 2.648 6.586.128 1.581.048 3.17-.048 4.75-.048.767 1.152.767 1.2 0 .176-2.818.264-5.74-.688-8.446-.864-2.459-2.544-4.423-4.88-5.589-1.288-.639-2.672-1.054-4.079-1.301-.752-.128-1.08 1.022-.32 1.158v-.009Zm-3.425 60.557c-.416.152-.832.312-1.248.464-.304.111-.512.407-.416.734.08.287.432.535.736.415.416-.152.832-.311 1.248-.463.304-.112.512-.407.416-.734-.08-.288-.432-.535-.736-.416ZM4.721 31.002c0 .774.008 1.548.016 2.323 0 .766 1.208.774 1.2 0 0-.775-.008-1.549-.016-2.323 0-.767-1.208-.775-1.2 0ZM95.156 14.82c.615-.159 1.239-.327 1.855-.487.744-.199.432-1.349-.32-1.157-.616.159-1.24.327-1.855.487-.745.199-.432 1.349.32 1.157ZM7.823 44.64c-1.488.67-2.032 1.213-2.696 2.69-.671-1.485-1.215-2.028-2.695-2.69 1.488-.671 2.032-1.214 2.695-2.691.672 1.485 1.216 2.028 2.696 2.691Zm124.666-28.791c-1.488.67-2.032 1.213-2.696 2.69-.671-1.485-1.215-2.028-2.695-2.69 1.488-.671 2.032-1.214 2.695-2.691.672 1.485 1.216 2.028 2.696 2.691ZM84.468 86.634c-1.488.67-2.032 1.213-2.696 2.69-.672-1.485-1.216-2.027-2.696-2.69 1.488-.671 2.032-1.214 2.696-2.691.672 1.485 1.216 2.028 2.696 2.691ZM2.752 39.689c-.48.215-.656.391-.872.87-.216-.479-.392-.655-.872-.87.48-.216.656-.392.872-.871.216.479.392.655.872.871ZM133.785 9.645c-.832.376-1.136.679-1.504 1.501-.376-.83-.68-1.133-1.504-1.501.832-.375 1.136-.678 1.504-1.5.376.83.68 1.133 1.504 1.5Zm-7.745 2.132c-.447.2-.615.368-.823.823-.2-.447-.368-.615-.824-.823.448-.199.616-.367.824-.822.2.447.368.615.823.822ZM85.644 82.051c-.448.199-.616.367-.824.822-.2-.447-.368-.615-.824-.822.448-.2.616-.367.824-.823.2.448.368.615.824.823Z"
										/>
										<path
											fill="currentColor"
											d="M57.173 66.642c.087.974.182 1.948.288 2.921.216 1.996.632 4.215 2.44 5.405 1.104.726 2.408.742 3.68.814 1.8.104 3.607.231 5.407.383 3.552.303 7.096.679 10.64 1.062 3.584.383 7.175.766 10.767 1.07 2.792.231 5.592.407 8.368.798 2.711.383 5.423.95 7.975 1.956a19.095 19.095 0 0 1 3.608 1.868c1.216.807 2.272 1.805 3.336 2.795 1.176 1.093 2.32 2.235 3.224 3.568.376.551 1.24.487 1.44-.183.687-2.331-.792-4.974.519-7.146.984-1.628 3.248-1.62 4.92-1.876 2.632-.399 5.952-.543 7.44-3.129.864-1.493 1.056-3.306 1.232-4.99.312-2.994.608-5.996.88-8.998.544-5.972.984-11.951 1.232-17.947.136-3.17.12-6.339.28-9.509.128-2.546.216-5.221-1.392-7.353l-.016-.008c-.016-.024-.04-.048-.056-.08-.016-.024-.04-.047-.064-.071-1.368-1.589-3.472-2.387-5.456-2.883-2.328-.582-4.744-.798-7.136-.942-6.287-.391-12.575-.846-18.871-1.269-5.825-.391-11.661-.786-17.498-1.027.064.465.127.93.188 1.395l.026.204c3.868.167 7.734.403 11.597.649 7.031.448 14.055.99 21.087 1.446 2.111.135 4.231.199 6.335.423 2.192.239 4.512.59 6.512 1.573.832.407 1.568.918 2.16 1.628 1.366 1.754 1.089 4.337.984 6.411v.008c-.136 2.744-.128 5.495-.224 8.239-.224 5.86-.632 11.72-1.144 17.564a634.508 634.508 0 0 1-.832 8.75c-.184 1.853-.216 3.936-1.024 5.653-1.144 2.427-4.504 2.411-6.848 2.77-2.056.311-4.256.487-5.543 2.347-.752 1.086-.968 2.419-.888 3.713.04.718.168 1.453.224 2.187a28.173 28.173 0 0 0-1.856-1.916c-1.024-.974-2.056-1.948-3.192-2.794-2.136-1.597-4.64-2.667-7.192-3.401-5.439-1.565-11.175-1.685-16.783-2.204-6.967-.646-13.911-1.54-20.895-2.067-.815-.064-1.631-.12-2.447-.168-.848-.056-1.728-.032-2.568-.16-.928-.143-1.704-.599-2.176-1.413-1.016-1.732-.912-4.111-1.096-6.043l-.02-.215-1.572.192Z"
										/>
										<path
											fill="currentColor"
											d="M57.173 66.642a790.84 790.84 0 0 1-3.408.406c-1.528.184-3.048.36-4.575.543-1.08.136-1.656.184-2.632.359l-.192.048c-.176.208-.488.415-.656.567a412.59 412.59 0 0 1-3.904 3.569 197.8 197.8 0 0 1-4.976 4.359c-1.256 1.062-2.528 2.195-3.951 3.026-.464.271-1.264-.064-1.184-.679.616-4.638 1.784-9.229 2.16-13.908a128.86 128.86 0 0 0-4.592-1.149c-3.712-.862-7.44-1.645-11.12-2.603a139.339 139.339 0 0 1-3.135-.854c-.8-.224-1.68-.471-2.04-1.301-.264-.599-.12-1.326-.184-1.964-.04-.4-.072-.807-.104-1.206-.384-4.686-.576-9.389-.752-14.091-.192-5.014-.344-10.028-.4-15.041-.016-1.597-.032-3.202.016-4.798.024-.695-.088-1.701.592-2.124.512-.312 1.176-.463 1.744-.623a82.53 82.53 0 0 1 3.351-.846c3.568-.838 7.16-1.589 10.752-2.323 4.656-.95 9.327-1.869 13.999-2.755 4.88-.926 9.767-1.828 14.663-2.69 4.24-.751 8.48-1.477 12.735-2.14 2.784-.439 5.584-.886 8.392-1.126 1.6-.079 3.056.24 3.84 1.773.536 1.046.768 2.259 1.04 3.401.264 1.086.488 2.179.704 3.273a120.6 120.6 0 0 1 1.004 6.126c.064.465.205 1.531.214 1.599a185.189 185.189 0 0 1 1.318 15.787l.007-.024c.201 4.623.273 9.269-.031 13.892-.105 1.62-.256 3.249-.553 4.846-.175.942-.383 2.012-.959 2.81-.568.79-1.552 1.174-2.424 1.509-1.336.511-2.744.854-4.136 1.174-3.888.886-7.832 1.485-11.775 2.035a482.368 482.368 0 0 1-8.848 1.143Zm1.432-1.762c2.882-.34 5.762-.691 8.632-1.113 3.743-.551 7.511-1.134 11.191-2.052.68-.167 1.36-.351 2.024-.559.304-.095.608-.191.904-.303.12-.048.544-.208.584-.232.216-.103.424-.199.624-.319.072-.048.144-.088.216-.136.032-.016.048-.04.064-.04l.024-.024c.056-.047.184-.175.184-.175a3.08 3.08 0 0 0 .136-.232l.096-.199c.104-.264.288-.894.376-1.294a21.14 21.14 0 0 0 .328-1.86c.232-1.756.336-3.537.408-5.309l-.008-.008c.184-4.742.072-9.501-.192-14.243-.247-4.467-.628-8.934-1.209-13.376-.069-.533-.142-1.064-.217-1.596l-.094-.652a101.006 101.006 0 0 0-1.232-6.89 69.144 69.144 0 0 0-.752-3.082c-.176-.646-.344-1.405-.832-1.9-.544-.543-1.392-.463-2.096-.423-.48.04-.96.088-1.44.144-2.984.343-6.112.846-9.215 1.349a831.332 831.332 0 0 0-13.144 2.267 1139.94 1139.94 0 0 0-14.455 2.691 912.875 912.875 0 0 0-13.271 2.651c-3.272.678-6.544 1.365-9.792 2.163-.936.224-1.88.455-2.799.751-.144.047-.28.095-.424.143l-.064.024v.088a8.332 8.332 0 0 0-.032.639 51.725 51.725 0 0 0-.032 1.924 233.33 233.33 0 0 0 .056 5.796c.096 5.126.264 10.243.48 15.361.184 4.199.504 8.39.768 12.582.016.359-.152.87.175 1.102.32.231.856.287 1.224.391a97.19 97.19 0 0 0 2.992.814c1.864.479 3.744.926 5.624 1.349 3.504.791 7.016 1.541 10.471 2.507.312.088.6.415.576.759-.288 4.319-1.288 8.558-1.96 12.83l.096-.072c3.216-2.475 6.216-5.262 9.208-8.008.832-.766 1.64-1.573 2.496-2.307.408-.36.984-.383 1.504-.455 3.401-.488 6.817-.884 10.232-1.283l1.567-.183Z"
										/>
									</svg>
								</div>
								<div v-else class="card-custom-img-container">
									<img
										:src="problem.img_url"
										alt="decorative image for problem"
										width="282"
										height="220"
									/>
								</div>
								<div class="card-body">
									<h5 v-sane-html="problem.currentTranslation.title" class="card-title"></h5>
									<p v-sane-html="problem.currentTranslation.description" class="card-text mb-4"></p>
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
	// eslint-disable-next-line vue/multi-word-component-names
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
		locale: {
			type: String,
			default: "en",
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
	watch: {
		projectId: "fetchProblems",
	},
	mounted() {
		this.fetchProblems();
	},
	methods: {
		...mapActions(["get"]),
		async fetchProblems() {
			this.loading = true;
			this.errorMessage = "";
			return this.get({
				url: window.route("api.problems.get") + `?projectId=${this.projectId}&lang=${this.locale}`,
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
};
</script>

<style scoped lang="scss">
ul {
	list-style-type: none;
	padding-left: 0;
}

h2 {
	font-weight: bold;
	margin-top: 2rem;
	margin-bottom: 2rem;
}

.card {
	border: none;
	box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);

	&:hover {
		box-shadow:
			0 4px 4px rgba(0, 0, 0, 0.25),
			0 4px 4px rgba(0, 0, 0, 0.25);

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
		outline: 0.25rem solid black;
	}
}

.card {
	border-radius: 1rem;
	margin-bottom: 2rem;
	overflow: clip;
}

.card-placeholder-img-container {
	background-color: var(--clr-secondary-grey);
	padding-top: 3.7rem;
	padding-bottom: 2.2rem;
	height: 220px;

	svg {
		width: 100%;
		color: var(--clr-secondary-light-grey);
	}
}

.card-custom-img-container {
	background-color: var(--clr-secondary-grey);
	height: 220px;

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
		font-size: 1.5rem;
		line-height: 1.83375rem;

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
		font-size: 1rem;
		line-height: 1.275;

		// truncate at 4 lines
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 4;
		line-clamp: 4;
		overflow: clip;
		height: 4lh;
	}
}

.share-circle-btn {
	position: absolute;
	top: 1rem;
	right: 2rem;
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
