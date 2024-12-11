import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
	server: {
		host: '0.0.0.0', // Allow Vite to listen on all network interfaces
		port: 5173, // Vite development server port (use this for hot-reloading)
		hmr: {
			host: 'localhost',
			port: 5173, // Same as above, make sure it's exposed in Docker
		},
		watch: {
			usePolling: true, // Useful for file changes in Docker
		},
		https: false,
	},
	plugins: [
		laravel({
			input: [
				"resources/assets/sass/auth.scss",
				"resources/assets/sass/common-backoffice.scss",
				"resources/assets/sass/common.scss",
				"resources/assets/sass/shared/errors.scss",
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
				"resources/assets/sass/questionnaire/questionnaire-statistics-colors.scss",
				"resources/assets/sass/questionnaire/questionnaire-thanks.scss",
				"resources/assets/sass/questionnaire/reports.scss",
				"resources/assets/sass/questionnaire/social-share.scss",
				"resources/assets/sass/questionnaire/statistics.scss",
				"resources/assets/sass/problem/create-edit-problem.scss",
				"resources/assets/sass/problem/landing-page.scss",
				"resources/assets/sass/problem/show-page.scss",
				"resources/assets/sass/solution/create-edit-solution.scss",
				"resources/assets/sass/gamification/progress.scss",
				"resources/assets/sass/pages/my-contributions.scss",
				"resources/assets/js/common-backoffice.js",
				"resources/assets/js/common.js",
				"resources/assets/js/pages/manage-users.js",
				"resources/assets/js/pages/register.js",
				"resources/assets/js/problem/landing-page.js",
				"resources/assets/js/problem/manage-problem.js",
				"resources/assets/js/problem/manage-problems.js",
				"resources/assets/js/problem/problem-page.js",
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
				"resources/assets/js/solution/manage-solution.js",
				"resources/assets/js/solution/manage-solutions.js",
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
