<template>
	<button class="heart-circle-btn" @click="upvote">
		<svg v-if="isFilled" width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
			<!-- <circle cx="22" cy="22" r="22" :fill="getIconColor()" opacity="0.8" /> -->
			<circle cx="22" cy="22" r="22" fill="white" />
			<path
				style="transform: translate(0.35em, 0.5em)"
				d="M16.4998 4.14573L16.4998 5.66785ZM16.4998 30.9376C-15.1245 10.0403 6.76272 -6.2699 16.1368 2.35754C16.2605 2.47166 16.3815 2.58923 16.4998 2.71023C16.616 2.58846 16.7371 2.47149 16.8628 2.3596C26.2348 -6.27402 48.1241 10.0383 16.4998 30.9376Z"
				fill="currentColor"
			/>
		</svg>
		<svg v-else width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
			<!-- <circle cx="22" cy="22" r="22" :fill="getIconColor()" opacity="0.8" /> -->
			<circle cx="22" cy="22" r="22" fill="white" />
			<path
				style="transform: translate(0.35em, 0.5em)"
				d="M16.4998 5.66785L15.021 4.14779C11.5498 0.579663 5.18491 1.81098 2.88728 6.29691C1.8086 8.40685 1.56522 11.4532 3.53491 15.341C5.43241 19.0844 9.38003 23.5683 16.4998 28.4523C23.6195 23.5683 27.5651 19.0844 29.4647 15.341C31.4343 11.4511 31.193 8.40685 30.1123 6.29691C27.8147 1.81098 21.4498 0.5776 17.9786 4.14573L16.4998 5.66785ZM16.4998 30.9376C-15.1245 10.0403 6.76272 -6.2699 16.1368 2.35754C16.2605 2.47166 16.3815 2.58923 16.4998 2.71023C16.616 2.58846 16.7371 2.47149 16.8628 2.3596C26.2348 -6.27402 48.1241 10.0383 16.4998 30.9376Z"
				fill="currentColor"
			/>
		</svg>
	</button>
</template>

<script>
import { showToast } from "../../common-utils";

export default {
	name: "HeartCircleButton",
	props: {
		isFilled: {
			type: Boolean,
			required: true,
		},
		iconColorTheme: {
			type: String,
			default: "light",
		},
	},
	methods: {
		getIconColor() {
			return this.iconColorTheme === "light" ? "#ffffff" : "#212529";
		},
	},
};
</script>

<style scoped>
.heart-circle-btn {
	background: none;
	border: none;
	padding: 0;
	cursor: pointer;
	border-radius: 50%;
	overflow: clip;
	background-color: transparent;
	color: var(--project-primary-color);

	&:hover {
		filter: brightness(90%);
		cursor: pointer;
	}

	&:focus-visible {
		outline: 0.1875rem solid var(--btn-text-color);
	}
}
</style>
