<template>
	<transition v-if="modal.open" name="modal">
		<div v-if="modal.open" class="modal-mask">
			<div class="modal-wrapper">
				<div class="modal-container">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 v-if="modal.title" class="modal-title">
									{{ modal.title }}
								</h5>
								<button
									v-if="modal.allowClose"
									tabindex="-1"
									type="button"
									class="close"
									@click.prevent="close"
								>
									<span aria-hidden="true"><i class="fas fa-times"></i></span>
								</button>
							</div>
							<div class="modal-body">
								<div class="container">
									<div class="row justify-content-center">
										<div class="col-10 text-center mx-auto">
											<span
												v-if="modal.loading"
												class="loader loader-lg loader-dark spinner-border spinner-border-sm"
												role="status"
												aria-hidden="true"
											></span>
											<h4
												v-if="modal.message"
												v-sane-html="modal.message"
												class="m-0 p-3 text-center message"
											></h4>
										</div>
									</div>
									<div v-if="modal.link && modal.link.url" class="row mt-4">
										<div class="col-md-8 col-sm-11 mx-auto">
											<a class="btn btn-primary" :href="modal.link.url">
												{{ modal.link.title }}
											</a>
										</div>
									</div>
								</div>
							</div>
							<div v-if="showOkButton" class="modal-footer">
								<button
									tabindex="-1"
									type="button"
									class="mx-auto btn btn-primary"
									@click="$emit('okClicked')"
								>
									Close
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

export default {
	name: "StoreModal",
	props: {
		showOkButton: {
			type: Boolean,
			default: false,
		},
	},
	setup() {
		const store = useStore();
		const modal = computed(() => store.getters.modal);

		const close = () => {
			store.dispatch('closeModal');
		};

		return {
			modal,
			close,
		};
	},
};
</script>

<style scoped lang="scss">
@import "../../../sass/modal";
</style>
