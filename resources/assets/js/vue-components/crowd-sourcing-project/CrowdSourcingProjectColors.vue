<template>
	<div class="container-fluid">
		<div class="row mb-3" v-for="(color, index) in colors" :key="'color_' + index">
			<div class="col-5">
				<div class="input-group">
					<input type="text" name="color_names[]" class="form-control" :value="color.color_name" />
					<input type="hidden" name="color_ids[]" :value="color.id" />
				</div>
			</div>
			<div class="col-6">
				<div class="input-group colorpicker-component color-picker" :id="'color_' + index">
					<input type="text" name="color_codes[]" class="form-control" :value="color.color_code" />
					<span class="input-group-addon"><i></i></span>
				</div>
			</div>
			<div class="col-1">
				<div @click="removeColor(index)" class="btn btn-block btn-outline-danger w-100">
					<i class="fas fa-minus"></i>
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-2">
				<div @click="addColor" class="btn btn-block btn-primary btn-lg w-100 mt-0">
					<i class="fas fa-plus"></i>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from "vuex";
import "jquery/dist/jquery.min";
import "bootstrap/dist/js/bootstrap.min";
import "bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min";

export default {
	name: "CrowdSourcingProjectColors",
	props: {
		colorData: [],
	},
	data: function () {
		return {
			colors: [],
		};
	},
	created() {
		this.colors = this.colorData;
	},
	mounted() {
		this.initializeColorPicker();
	},
	methods: {
		...mapActions(["get", "handleError", "closeModal"]),
		addColor() {
			this.colors.push({
				color_name: "color-" + (this.colors.length + 1),
				color_code: this.generateRandomColor(),
			});
			let instance = this;
			setTimeout(function () {
				instance.initSingleColorPicker($("#color_" + (instance.colors.length - 1)));
			}, 500);
		},
		generateRandomColor() {
			return (
				"#" +
				Math.floor(Math.random() * 16777215)
					.toString(16)
					.toUpperCase()
			);
		},
		removeColor(index) {
			this.colors.splice(index, 1);
			for (let i = 0; i < this.colors.length; i++) {
				$("#color_" + i).colorpicker("setValue", this.colors[i].color_code);
			}
		},
		initializeColorPicker() {
			let instance = this;
			$(".color-picker").each(function (i, el) {
				instance.initSingleColorPicker(el);
			});
		},
		initSingleColorPicker(el) {
			$(el).colorpicker({
				horizontal: true,
			});

			$(el).on("colorpickerCreate", function (event) {
				$(el).find(".input-group-addon").css("background-color", event.color.toString());
			});

			$(el).on("colorpickerChange", function (event) {
				$(el).find(".input-group-addon").css("background-color", event.color.toString());
			});
		},
	},
};
</script>

<style lang="scss">
@import "resources/assets/sass/variables";
@import "~survey-jquery/modern.min.css";
@import "~survey-analytics/survey.analytics.min.css";
@import "~bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css";
</style>
