<template>
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Crowdsourcing Projects Problems</h3>
					</div>
					<div class="card-body">
						<div class="container-fluid px-0">
							<div class="row px-0">
								<div class="col">
									<div
										v-if="errorMessage.length"
										id="errorMsg"
										class="alert alert-danger stickyAlert margin-top margin-bottom"
										role="alert"
									>
										<h6 class="mb-0">{{ errorMessage }}</h6>
									</div>
								</div>
							</div>
							<div class="row px-0">
								<div class="col">
									<div class="mb-3">
										<label for="projectSelect" class="form-label"
											>Select a Project to view the problems</label
										>
										<select
											id="projectSelect"
											class="form-select form-control"
											v-model="selectedProject"
											@change="getProjectProblems"
										>
											<option v-for="project in projects" :key="project.id" :value="project.id">
												{{ project.default_translation.name }}
											</option>
										</select>
									</div>
									<div v-if="problems.length">
										<h6>Problems:</h6>
										<ul>
											<li v-for="problem in problems" :key="problem.id">
												{{ problem.description }}
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions } from "vuex";

export default {
	name: "ProblemsManagement",
	data() {
		return {
			projects: [],
			selectedProject: null,
			problems: [],
			errorMessage: "",
			loading: false,
		};
	},
	mounted() {
		console.log("ProblemsManagement.vue mounted");
		this.getCrowdSourcingProjectsForFiltering();
	},
	methods: {
		...mapActions(["get", "handleError", "post"]),
		getCrowdSourcingProjectsForFiltering() {
			this.get({
				url: window.route("api.crowd-sourcing-projects.for-problems.get"),
				data: {},
				urlRelative: false,
			})
				.then((response) => {
					this.projects = response.data;
					console.log("getCrowdSourcingProjectsForFiltering", response);
				})
				.catch((error) => {
					this.handleError(error);
				});
		},
		getProjectProblems() {
			if (this.selectedProject) {
				this.post({
					url: window.route("api.crowd-sourcing-projects.problems.get-management"),
					data: { projectId: this.selectedProject },
					urlRelative: false,
				})
					.then((response) => {
						this.problems = response.data;
						console.log("fetchProjectProblems", response);
					})
					.catch((error) => {
						this.handleError(error);
					});
			}
		},
	},
};
</script>

<style scoped lang="scss"></style>
