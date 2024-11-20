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
				<div :id="'color_' + index" class="input-group colorpicker-component color-picker">
					<input type="text" name="color_codes[]" class="form-control" :value="color.color_code" />
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="col-1">
				<div class="btn btn-block btn-outline-danger btn-slimmer w-100" @click="removeColor(index)">
					<i class="fas fa-minus"></i>
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-2">
				<div class="btn btn-block btn-primary btn-lg btn-slim w-100 mt-0" @click="addColor">
					<i class="fas fa-plus"></i>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { ref, onMounted, nextTick } from "vue";
import $ from "jquery";
import "bootstrap/dist/js/bootstrap.bundle.min";
import "bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min";

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
				Math.floor(Math.random() * 16777215)
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
			initSingleColorPicker($(`#color_${colors.value.length - 1}`));
		};

		const removeColor = (index) => {
			colors.value.splice(index, 1);
			colors.value.forEach((color, i) => {
				$(`#color_${i}`).colorpicker("setValue", color.color_code);
			});
		};

		const initSingleColorPicker = (el) => {
			$(el).colorpicker({ horizontal: true });

			$(el).on("colorpickerCreate", (event) => {
				$(el).find(".input-group-addon").css("background-color", event.color.toString());
			});

			$(el).on("colorpickerChange", (event) => {
				$(el).find(".input-group-addon").css("background-color", event.color.toString());
			});
		};

		const initializeColorPicker = () => {
			$(".color-picker").each((i, el) => {
				initSingleColorPicker(el);
			});
		};

		onMounted(initializeColorPicker);

		return {
			colors,
			addColor,
			removeColor,
			generateRandomColor,
			initializeColorPicker,
			initSingleColorPicker,
		};
	},
};
</script>

<style lang="scss">
@import "resources/assets/sass/variables";
@import "survey-jquery/modern.min.css";
@import "survey-analytics/survey.analytics.min.css";
@import "bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css";
</style>
