<template>
	<div class="row justify-content-center py-5">
		<div class="col-lg-12 col-md-10 col-lg-11 col-xl-9">
			<div class="text-center p-0">
				<button
					:class="['btn', 'call-to-action', projectAcceptingSolutions ? 'btn-primary' : 'btn-secondary']"
					:disabled="!projectAcceptingSolutions"
					:title="
						projectAcceptingSolutions
							? trans('solution.propose_solution_title')
							: trans('solution.submission_closed')
					"
					@click="goToProposeSolutionPage"
				>
					{{
						projectAcceptingSolutions
							? trans("solution.propose_solution_title")
							: trans("solution.submission_closed")
					}}
				</button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "ProposeSolution",
	props: {
		projectAcceptingSolutions: {
			type: Boolean,
			required: false,
			default: true,
		},
	},
	methods: {
		goToProposeSolutionPage() {
			// Only navigate if submissions are open
			if (!this.projectAcceptingSolutions) {
				return;
			}

			let currentUrl = window.location.href;
			if (!currentUrl.endsWith("/")) {
				currentUrl += "/";
			}
			window.location.href = currentUrl + "solutions/propose";
		},
		trans(key) {
			return window.trans(key);
		},
	},
};
</script>

<style scoped></style>
