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
import { computed } from "vue";
import { useStore } from "vuex";

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
			store.dispatch("closeModal");
		};

		return {
			modal,
			close,
		};
	},
};
</script>

<style scoped lang="scss">
@import "../../../sass/_variables.scss";

.modal-mask {
	position: fixed;
	z-index: 9998;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, 0.5);
	display: table;
	transition: opacity 0.3s ease;
}

.modal-container {
	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
	transition: all 0.3s ease;
}

.modal-wrapper {
	display: table-cell;
	vertical-align: top;
	padding-top: 10%;

	.modal-container {
		box-shadow: none;
	}
}

.modal-body {
	padding-bottom: 2rem;
	padding-top: 2rem;

	.message {
		color: $green;
		word-break: break-word;
	}
}

.modal-enter {
	opacity: 0;
}

.modal-leave-active {
	opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
	-webkit-transform: scale(1.1);
	transform: scale(1.1);
}
</style>
