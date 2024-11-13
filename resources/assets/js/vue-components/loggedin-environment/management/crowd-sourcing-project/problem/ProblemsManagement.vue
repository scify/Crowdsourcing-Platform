<template>
	<div class="container-fluid px-0">
		<div class="row px-0">
			<div class="col">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Crowdsourcing Projects Problems</h3>
					</div>
					<div class="card-body">
						<div class="container-fluid px-0">
							<div class="row px-0 mb-3">
								<div class="col-12">
									<label for="projectSelect" class="form-label mb-0"
										>Select a Project to view the problems</label
									>
									<div :class="{ 'spinner-border text-primary ml-5': true, hidden: !loading }"></div>
									<select
										id="projectSelect"
										class="form-select form-control mt-3"
										v-model="selectedProject"
										@change="getProjectProblems"
									>
										<option value="" disabled selected>Select a Project</option>
										<option v-for="project in projects" :key="project.id" :value="project.id">
											{{ project.default_translation.name }}
										</option>
									</select>
								</div>
							</div>
							<div class="row px-0 mb-3">
								<div class="col">
									<div class="form-check mb-3">
										<input
											class="form-check-input"
											type="checkbox"
											id="filterUnpublishedProblems"
											@change="toggleShowUnpublishedProblems"
										/>
										<label class="form-check-label" for="filterUnpublishedProblems">
											Show only unpublished problems
										</label>
									</div>
								</div>
							</div>
							<div class="row px-0">
								<div class="col" :class="[fetched && problems.length ? '' : 'd-none']">
									<table
										id="problemsTable"
										class="display table table-striped table-bordered"
									></table>
								</div>
							</div>
							<div class="row px-0">
								<div class="col" :class="[fetched && !problems.length ? '' : 'hidden']">
									<div class="alert alert-warning">No problems found for the selected project</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Delete Confirmation Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>
						Are you sure you want to delete the problem <b>{{ deleteProblem.title }}</b
					>?
					</p>

					<h5 class="text-danger">
						<b><i class="fas fa-exclamation-triangle mr-2"></i>This action is irreversible!</b>
					</h5>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-slim" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger btn-slim" @click="confirmDelete">
							<span
								:class="['spinner-border spinner-border-sm mr-2', { hidden: !deleteLoading }]"
								role="status"
								aria-hidden="true"
							></span
							>In understand, Delete the problem
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-component">
	</div>
	<div class="alert-component position-relative d-none" id="problemDeletedAlert">
		<div class="alert alert-success" role="alert">
			The problem has been successfully deleted.
		</div>
	</div>
	<div class="alert-component position-relative d-none" id="errorAlert">
		<div class="alert alert-danger" role="alert">
			{{ errorMessage }}
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import $ from "jquery";
import "datatables.net";
import Modal from "bootstrap/js/dist/modal"; // Import Bootstrap modal
import axios from "axios";
import CommonModal from "../../../../common/ModalComponent.vue";

export default {
	name: "ProblemsManagement",
	components: { CommonModal },
	data() {
		return {
			fetched: false,
			projects: [],
			selectedProject: "",
			problems: [],
			problemStatuses: [],
			errorMessage: "",
			showUnpublishedProblemsOnly: false,
			filteredProblems: [],
			dataTableInstance: null,
			deleteProblem: {
				id: null,
				title: "",
			},
			deleteModal: null,
			deleteLoading: false,
		};
	},
	computed: {
		...mapState(["loading", "modal"]),
	},
	async mounted() {
		this.deleteModal = new Modal(document.getElementById("deleteModal"));
		await this.getProblemStatusesForManagementPage();
		await this.getCrowdSourcingProjectsForFiltering();
		await this.$nextTick(() => {
			this.dataTableInstance = $("#problemsTable").DataTable({
				pageLength: 5,
				data: [],
				columns: [
					{ title: "#", data: null },
					{ title: "Title", data: "title" },
					{ title: "Bookmarks", data: "bookmarks" },
					{ title: "Languages", data: "languages" },
					{ title: "Status", data: "status" },
					{ title: "Actions", data: "actions" },
				],
				columnDefs: [
					{
						targets: 0,
						render: (data, type, row, meta) => meta.row + 1,
					},
				],
			});

			// Event delegation for delete button clicks
			$("#problemsTable tbody").on("click", ".delete-btn", (event) => {
				const problemId = $(event.currentTarget).data("id");
				const problemTitle = $(event.currentTarget).data("title");
				this.openDeleteModal(problemId, problemTitle);
			});
		});
	},
	methods: {
		...mapActions(["get", "post", "setLoading"]),

		async getProblemStatusesForManagementPage() {
			return this.get({
				url: window.route("api.problems.statuses.management.get"),
				data: {},
				urlRelative: false,
			})
				.then((response) => {
					this.problemStatuses = response.data;
				})
				.catch((error) => {
					this.showErrorMessage(error);
				});
		},

		async getCrowdSourcingProjectsForFiltering() {
			return this.get({
				url: window.route("api.crowd-sourcing-projects.for-problems.get"),
				data: {},
				urlRelative: false,
			})
				.then((response) => {
					this.projects = response.data;
				})
				.catch((error) => {
					this.showErrorMessage(error);
				});
		},

		getProjectProblems() {
			if (this.selectedProject) {
				this.fetched = false;
				this.problems = [];
				this.post({
					url: window.route("api.crowd-sourcing-projects.problems.get-management"),
					data: { projectId: this.selectedProject },
					urlRelative: false,
				})
					.then((response) => {
						this.problems = response.data;
						this.fetched = true;
						this.updateFilteredProblems();
						this.updateDataTable();
					})
					.catch((error) => {
						this.showErrorMessage(error);
					});
			}
		},

		toggleShowUnpublishedProblems() {
			this.showUnpublishedProblemsOnly = !this.showUnpublishedProblemsOnly;
			this.updateFilteredProblems();
			this.updateDataTable();
		},

		updateFilteredProblems() {
			this.filteredProblems = this.showUnpublishedProblemsOnly
				? this.problems.filter((problem) => problem.status.id === 1)
				: this.problems;
		},

		updateDataTable() {
			this.$nextTick(() => {
				if (this.dataTableInstance) {
					this.dataTableInstance.clear();
					const tableData = this.filteredProblems.map((problem, index) => ({
						title: problem.default_translation.title,
						bookmarks: "TODO",
						languages: problem.translations
							? problem.translations.map((t) => t.language.language_name).join(", ")
							: "",
						status: `<span title="${this.getBadgeTitleForProblemStatus(problem.status)}"
                                  class="p-2 badge ${this.getBadgeClassForProblemStatus(problem.status)}">
                                  ${problem.status.title}</span>`,
						actions: `<div class="dropdown">
									<button class="btn btn-primary btn-slimmer dropdown-toggle" type="button"
											data-toggle="dropdown">
										Select an action <span class="caret"></span>
									</button>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="action-btn dropdown-item" target="_blank" href="${this.getProblemEditRoute(problem)}">
											<i class="far fa-edit mr-2"></i> Edit</a>
										<a href="javascript:void(0)" class="dropdown-item delete-btn" data-id="${problem.id}" data-title="${problem.default_translation.title}">
											<i class="fas fa-trash mr-2"></i> Delete</a>
									</div>
								  </div>`,
					}));
					this.dataTableInstance.rows.add(tableData).draw();
				}
			});
		},

		getBadgeClassForProblemStatus(problemStatus) {
			// search by id in the problemStatuses array
			const status = this.problemStatuses.find((status) => status.id === problemStatus.id);
			return status ? status.badgeCSSClass : "badge-secondary";
		},
		getBadgeTitleForProblemStatus(problemStatus) {
			const status = this.problemStatuses.find((status) => status.id === problemStatus.id);
			return status ? status.description : "Unknown status";
		},
		getProblemEditRoute(problem) {
			return window.route("problems.edit", problem.id);
		},

		openDeleteModal(problemId, problemTitle) {
			this.deleteProblem = {
				id: problemId,
				title: problemTitle,
			};
			this.deleteModal.show();
		},

		confirmDelete() {
			if (!this.deleteProblem.id) return;
			this.deleteLoading = true;
			axios
				.delete(window.route("problems.destroy", this.deleteProblem.id))
				.then(() => {
					this.getProjectProblems();
					this.deleteProblem.id = null;
					this.deleteProblem.title = "";
					this.showSuccessAlert();
				})
				.catch((error) => {
					this.showErrorMessage(error);
				})
				.finally(() => {
					this.deleteModal.hide();
					this.deleteLoading = false;
				});
		},
		showSuccessAlert() {
			const alertElement = document.querySelector("#problemDeletedAlert");
			alertElement.classList.remove("d-none");
			setTimeout(() => {
				alertElement.classList.add("d-none");
			}, 5000);
		},
		showErrorMessage(error) {
			// first check if the error message is just a string
			if (typeof error === "string") {
				this.errorMessage = error;
			} else if (error.response && error.response.data && error.response.data.message) {
				this.errorMessage = error.response.data.message;
			} else {
				this.errorMessage = `An error occurred. Please try again later. Error: ${error}`;
			}
			const alertElement = document.querySelector("#errorAlert");
			alertElement.classList.remove("d-none");
			setTimeout(() => {
				alertElement.classList.add("d-none");
			}, 5000);
		},
	},
};
</script>
