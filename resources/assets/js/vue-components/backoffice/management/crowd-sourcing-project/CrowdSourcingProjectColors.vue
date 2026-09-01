<template>
	<div class="container-fluid">
		<div v-for="(color, index) in colors" :key="'color_' + index" class="row mb-3">
			<div class="col-5">
				<div class="input-group">
					<input type="text" name="color_names[]" class="form-control" :value="color.color_name" />
					<input type="hidden" name="color_ids[]" :value="color.id" />
				</div>
			</div>
			<div class="col-6">
				<div class="input-group">
					<input
						:id="'color_' + index"
						type="text"
						name="color_codes[]"
						class="form-control color-picker-input"
						:value="color.color_code"
					/>
				</div>
			</div>
			<div class="col-1">
				<div class="btn btn-outline-danger btn-slimmer w-100" @click="removeColor(index)">
					<i class="fas fa-minus"></i>
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-2">
				<div class="btn btn-primary btn-lg btn-slim w-100 mt-0" @click="addColor">
					<i class="fas fa-plus"></i>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { ref, onMounted, nextTick } from "vue";
import "bootstrap/dist/js/bootstrap.bundle.min";
import Coloris from "@melloware/coloris";

export default {
	name: "CrowdSourcingProjectColors",
	props: {
		colorData: {
			type: Array,
			default: () => [],
		},
	},
	setup(props) {
		const colors = ref([...props.colorData]);

		const generateRandomColor = () => {
			return (
				"#" +
				Math.floor(Math.random() * 16777215) // NOSONAR - Using for UI colors only, not security-sensitive
					.toString(16)
					.toUpperCase()
			);
		};

		const addColor = async () => {
			colors.value.push({
				color_name: "color-" + (colors.value.length + 1),
				color_code: generateRandomColor(),
			});
			await nextTick();
			Coloris.wrap(".color-picker-input");
		};

		const removeColor = (index) => {
			colors.value.splice(index, 1);
			colors.value.forEach((color, i) => {
				const input = document.getElementById(`color_${i}`);
				if (input) {
					input.value = color.color_code;
					input.dispatchEvent(new Event("input", { bubbles: true }));
				}
			});
		};

		const initializeColorPicker = () => {
			Coloris.init();
			Coloris({
				el: ".color-picker-input",
				format: "hex",
			});
		};

		onMounted(initializeColorPicker);

		return {
			colors,
			addColor,
			removeColor,
			generateRandomColor,
			initializeColorPicker,
		};
	},
};
</script>

<style lang="scss">
@import "../../../../../sass/variables.scss";
@import "survey-jquery/modern.min.css";
@import "survey-analytics/survey.analytics.min.css";
@import "@melloware/coloris/dist/coloris.css";
</style>
