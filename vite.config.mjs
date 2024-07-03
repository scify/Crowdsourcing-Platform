import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
	// declaring the base path for the project
	server: {
		port: 3000,
		hmr: {
			host: "localhost",
			protocol: "ws",
		},
	},
	plugins: [
		laravel({
			input: [
				"resources/assets/sass/auth.scss",
				"resources/assets/sass/common-backoffice.scss",
				"resources/assets/sass/common.scss",
				"resources/assets/sass/errors.scss",
				"resources/assets/sass/gamification/badge-single.scss",
				"resources/assets/sass/gamification/badges.scss",
				"resources/assets/sass/gamification/next-step.scss",
				"resources/assets/sass/pages/home.scss",
				"resources/assets/sass/pages/my-dashboard.scss",
				"resources/assets/sass/project/all-projects.scss",
				"resources/assets/sass/project/create-edit-project.scss",
				"resources/assets/sass/project/landing-page.scss",
				"resources/assets/sass/project/projects-list.scss",
				"resources/assets/sass/questionnaire/create-questionnaire.scss",
				"resources/assets/sass/questionnaire/manage-questionnaires.scss",
				"resources/assets/sass/questionnaire/my-questionnaire-responses.scss",
				"resources/assets/sass/questionnaire/questionnaire-statistics-colors.scss",
				"resources/assets/sass/questionnaire/questionnaire-thanks.scss",
				"resources/assets/sass/questionnaire/reports.scss",
				"resources/assets/sass/questionnaire/social-share.scss",
				"resources/assets/sass/questionnaire/statistics.scss",
				"resources/assets/js/common-backoffice.js",
				"resources/assets/js/common.js",
				"resources/assets/js/pages/manage-users.js",
				"resources/assets/js/pages/register.js",
				"resources/assets/js/partials/newsletter-signup.js",
				"resources/assets/js/project/landing-page.js",
				"resources/assets/js/project/manage-project.js",
				"resources/assets/js/questionnaire/manage-questionnaires.js",
				"resources/assets/js/questionnaire/my-questionnaire-responses.js",
				"resources/assets/js/questionnaire/questionnaire-create-edit.js",
				"resources/assets/js/questionnaire/questionnaire-page.js",
				"resources/assets/js/questionnaire/questionnaire-reports.js",
				"resources/assets/js/questionnaire/questionnaire-social-share.js",
				"resources/assets/js/questionnaire/questionnaire-statistics-colors.js",
				"resources/assets/js/questionnaire/questionnaire-statistics.js",
				"resources/assets/js/questionnaire/questionnaire-thanks.js",
			],
			refresh: true,
		}),
		vue({
			template: {
				transformAssetUrls: {
					base: null,
					includeAbsolute: false,
				},
			},
		}),
	],
	resolve: {
		alias: {
			jQuery: path.resolve(__dirname, "node_modules/jquery/dist/jquery.js"),
			vue: "vue/dist/vue.esm-bundler.js",
		},
		fallback: {
			fs: false,
			path: false,
			stream: false,
			constants: false,
			crypto: false,
		},
	},
});
