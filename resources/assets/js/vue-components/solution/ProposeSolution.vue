<template>
	<div class="row justify-content-center py-5">
		<div class="col-12 col-md-10 col-lg-11 col-xl-9">
			<div class="text-center p-0">
				<button class="btn btn-primary call-to-action" @click="goToProposeSolutionPage">
					Propose a Solution
				</button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "ProposeSolution",
	methods: {
		goToProposeSolutionPage() {
			let currentUrl = window.location.href;
			if (!currentUrl.endsWith("/")) {
				currentUrl += "/";
			}
			window.location.href = currentUrl + "solutions/propose";
		},
	},
};
</script>

<style scoped></style>
