<template>
	<transition v-if="open" name="modal" @click="cancel">
		<div v-if="open" class="modal-mask">
			<div class="modal-wrapper">
				<div class="modal-container">
					<div class="modal-dialog modal-dialog-scrollable" :class="additionalClasses">
						<div class="modal-content">
							<div v-if="!hideHeader" class="modal-header">
								<slot name="header"></slot>
								<button
									v-if="allowClose"
									type="button"
									class="close"
									data-dismiss="modal"
									aria-label="Close"
									@click="cancel"
								>
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body p-0">
								<slot name="body"></slot>
							</div>
							<div v-if="hasSlot('footer')" class="modal-footer">
								<slot name="footer"></slot>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
	name: "CommonModal",
	props: {
		allowClose: {
			type: Boolean,
			default: false,
		},
		open: {
			type: Boolean,
			default: false,
		},
		hideHeader: {
			type: Boolean,
			default: false,
		},
		additionalClasses: {
			type: String,
			default: "modal-lg",
		},
	},
	methods: {
		cancel() {
			this.$emit("canceled");
		},
		submit() {
			this.$emit("submit");
		},
		hasSlot(name = "default") {
			return !!this.$slots[name];
		},
	},
});
</script>

<style scoped lang="scss">
@import "resources/assets/sass/variables";
@import "resources/assets/sass/shared/modal";
</style>
