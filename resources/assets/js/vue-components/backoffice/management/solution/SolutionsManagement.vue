<template>
	<div class="container-fluid px-0">
		<div class="row px-0">
			<div class="col">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Crowdsourcing Projects Problems Solutions</h3>
					</div>
					<div class="card-body">
						<div class="container-fluid px-0">
							<div class="row px-0 mb-3">
								<div class="col-12">
									<label for="projectSelect" class="form-label mb-0"
										>Select a Project to view the Solutions</label
									>
									<div :class="{ 'spinner-border text-primary ml-5': true, hidden: !projectsLoading }"></div>
									<select
										id="projectSelect"
										:class="['form-select form-control mt-3', projectsFetched ? '' : 'hidden']"
										v-model="selectedProjectId"
										@change="getProblemsForFiltering"
									>
										<option value="" disabled selected>Select a Project</option>
										<option v-for="project in projects" :key="project.id" :value="project.id">
											{{ project.default_translation.name }}
										</option>
									</select>
								</div>
							</div>
							<div :class="['row px-0 mb-3', selectedProjectId ? '' : 'hidden']">
								<div class="col-12">
									<label for="problemSelect" class="form-label mb-0"
										>Select a Problem to further filter the Solutions</label
									>
									<div :class="{ 'spinner-border text-primary ml-5': true, hidden: !problemsLoading }"></div>
									<select
										id="problemSelect"
										:class="['form-select form-control mt-3', problemsFetched ? '' : 'hidden']"
										v-model="selectedProblemId"
										@change="getFilteredSolutions"
									>
										<option value="" disabled selected>Select a Problem</option>
										<!-- /* bookmark4 - what goes here? */ -->
										<option value="all">View all Project's Solutions</option>
										<!-- /* bookmark4 - what goes here? */ -->
										<option v-for="problem in problems" :key="problem.id" :value="problem.id">
											{{ problem.default_translation.title }}
										</option>
									</select>
								</div>
							</div>
							<div :class="['row px-0 mb-3', fetched ? '' : 'hidden']">
								<div class="col">
									<div class="form-check mb-3">
										<input
											class="form-check-input"
											type="checkbox"
											id="filterUnpublishedSolutions"
											@change="toggleShowUnpublishedSolutions"
										/>
										<label class="form-check-label" for="filterUnpublishedSolutions">
											Show only unpublished solutions
										</label>
									</div>
								</div>
							</div>
							<div class="row px-0 mb-3">
								<div class="col text-center">
									<div
										:class="{ 'spinner-border text-primary ml-5': true, hidden: !solutionsLoading }"
									></div>
								</div>
							</div>
							<div class="row px-0">
								<div class="col" :class="[fetched && solutions.length ? '' : 'd-none']">
									<table
										id="solutionsTable"
										class="display table table-striped table-bordered"
									></table>
								</div>
							</div>
							<div class="row px-0">
								<div class="col" :class="[fetched && !solutions.length ? '' : 'hidden']">
									<div class="alert alert-warning">No Solutions found for the selected Filters</div>
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
				<div class="modal-body" v-if="modalProblem.id">
					<p>
						Are you sure you want to delete the solution
						<b>{{ modalProblem.default_translation.title }}</b
						>?
					</p>

					<h5 class="text-danger">
						<b><i class="fas fa-exclamation-triangle mr-2"></i>This action is irreversible!</b>
					</h5>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-slim" data-dismiss="modal">Cancel</button>
					<button
						type="button"
						class="btn btn-danger btn-slim"
						@click="confirmDelete"
						:disabled="modalActionLoading"
					>
						<span
							:class="['spinner-border spinner-border-sm mr-2', { 'd-none': !modalActionLoading }]"
							role="status"
							aria-hidden="true"
						></span
						>I understand, Delete the problem
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Update Problem Status Modal -->
	<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateModalLabel">Update Problem Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" v-if="modalProblem.id && solutionStatuses.length">
					<p>
						Select a new status for the solution <b>{{ modalProblem.default_translation.title }}</b>
					</p>
					<select class="form-select form-control" v-model="modalProblem.status.id">
						<option v-for="status in solutionStatuses" :key="status.id" :value="status.id">
							{{ status.title }}
						</option>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-slim" data-dismiss="modal">Cancel</button>
					<button
						type="button"
						class="btn btn-primary btn-slim"
						@click="confirmUpdate"
						:disabled="modalActionLoading"
					>
						<span
							:class="['spinner-border spinner-border-sm mr-2', { 'd-none': !modalActionLoading }]"
							role="status"
							aria-hidden="true"
						></span
						>Update
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="alert-component position-relative d-none" id="solutionDeletedAlert">
		<div class="alert alert-success" role="alert">
			{{ actionSuccessMessage }}
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
import Modal from "bootstrap/js/dist/modal";
import axios from "axios";
import CommonModal from "../../../common/ModalComponent.vue";
import { getLocale } from "../../../../common-utils";

export default {
	name: "SolutionsManagement",
	components: { CommonModal },
	data() {
		return {
			fetched: false,
			projects: [],
			selectedProjectId: "",
			problems: [],
			selectedProblemId: "",
			solutions: [],
			solutionStatuses: [],
			errorMessage: "",
			showUnpublishedSolutionsOnly: false,
			filteredSolutions: [],
			dataTableInstance: null,
			modalProblem: {},
			deleteModal: null,
			updateModal: null,
			modalActionLoading: false,
			actionSuccessMessage: "",
			projectsFetched: false,
			problemsFetched: false,
			solutionsLoading: false,
			projectsLoading: false,
			problemsLoading: false,
		};
	},
	computed: {
		...mapState(["modal"]),
	},
	async mounted() {
		this.deleteModal = new Modal(document.getElementById("deleteModal"));
		this.updateModal = new Modal(document.getElementById("updateModal"));
		await this.getSolutionStatusesForManagementPage();
		await this.getProjectsForFiltering();
		await this.getFilteredSolutions();
		await this.setUpDataTable();
	},
	methods: {
		...mapActions(["get", "post"]),

		async setUpDataTable() {
			await this.$nextTick(() => {
				this.dataTableInstance = $("#solutionsTable").DataTable({
					pageLength: 5,
					autoWidth: false,
					data: [],
					columns: [
						{ title: "#", data: null, width: "5%" },
						{ title: "Title", data: "title", width: "25%" },
						{ title: "Upvotes", data: "upvotes", width: "5%" },
						{ title: "Languages", data: "languages", width: "20%" },
						{ title: "Author", data: "user", width: "20%" },
						{ title: "Status", data: "status", width: "10%" },
						{ title: "Actions", data: "actions", width: "15%" },
					],
					columnDefs: [
						{
							targets: 0,
							render: (data, type, row, meta) => meta.row + 1,
						},
						{
							targets: [0, 2, 4, 5], // Indices of columns to center
							className: "text-center",
						},
					],
				});

				// Event listener for action items clicks
				const actions = ["delete-btn", "update-btn"];
				actions.forEach((action) => {
					$("#solutionsTable tbody").on("click", `.${action}`, (event) => {
						const solutionId = parseInt(event.target.getAttribute("data-id"));
						const solution = this.solutions.find((p) => p.id === solutionId);
						if (action === "delete-btn") {
							this.openDeleteModal(solution);
						} else if (action === "update-btn") {
							this.openUpdateModal(solution);
						}
					});
				});
			});
		},

		async getSolutionStatusesForManagementPage() {
			return this.get({
				url: window.route("api.management.solutions.statuses.get"),
				data: {},
				urlRelative: false,
			})
				.then((response) => {
					this.solutionStatuses = response.data;
				})
				.catch((error) => {
					this.showErrorMessage(error);
				});
		},

		async getProjectsForFiltering() {
			this.projectsLoading = true;
			return this.get({
				url: window.route("api.projects.get"),
				data: {},
				urlRelative: false,
			})
				.then((response) => {
					this.projects = response.data;
					this.projectsFetched = true;
					// if only one project is available, select it by default and fetch its problems
					if (this.projects.length === 1) {
						this.selectedProjectId = this.projects[0].id;
						this.getProblemsForFiltering();
					}
				})
				.catch((error) => {
					this.showErrorMessage(error);
				}).finally(() => {
					this.projectsLoading = false;
				});
		},

		getProblemsForFiltering() {
			this.problemsLoading = true;
			if (this.selectedProjectId) {
				this.problemsFetched = false;
				this.problems = [];
				this.post({
					url: window.route("api.management.solutions.problems.get"),
					data: { projectId: this.selectedProjectId },
					urlRelative: false,
				})
					.then((response) => {
						this.problems = response.data;
						this.problemsFetched = true;
						// this.updateProblems(); // bookmark4
					})
					.catch((error) => {
						this.showErrorMessage(error);
					}).finally(() => {
						this.problemsLoading = false;
					});
			}
		},

		async getFilteredSolutions() {
			if (this.projects.length || this.problems.length) {
				this.fetched = false;
				this.solutionsLoading = true;
				this.solutions = [];
				let data = {
					filters: {
						projectFilters: this.projects.map((x) => x.id),
						problemFilters: this.problems.map((x) => x.id),
					},
				};
				this.post({
					url: window.route("api.management.solutions.get"),
					data: data,
					urlRelative: false,
				})
					.then((response) => {
						this.solutions = response.data;
						this.fetched = true;
						this.updateFilteredSolutions();
						this.updateDataTable();
					})
					.catch((error) => {
						this.showErrorMessage(error);
					})
					.finally(() => {
						this.solutionsLoading = false;
					});
			}
		},

		toggleShowUnpublishedSolutions() {
			this.showUnpublishedSolutionsOnly = !this.showUnpublishedSolutionsOnly;
			this.updateFilteredSolutions();
			this.updateDataTable();
		},

		updateFilteredSolutions() {
			this.filteredSolutions = this.showUnpublishedSolutionsOnly
				? this.solutions.filter((solution) => solution.status.id === 1)
				: this.solutions;
		},

		updateDataTable() {
			this.$nextTick(() => {
				if (this.dataTableInstance) {
					this.dataTableInstance.clear();
					const tableData = this.filteredSolutions.map((solution, index) => ({
						title: solution?.default_translation?.title ?? "Untitled",
						upvotes: solution.upvotes_count,
						languages: solution.translations
							? solution.translations.map((t) => t.language.language_name).join(", ")
							: "",
						user: solution?.user?.nickname ?? "N/A",
						status: `<span title="${this.getBadgeTitleForSolutionStatusId(solution.status_id)}"
                                  class="p-2 w-75 badge ${this.getBadgeClassForSolutionStatusId(solution.status_id)}">
                                  ${this.getStatusTitleForSolutionStatusId(solution.status_id)}</span>`,
						actions: `<div class="dropdown">
									<button class="btn btn-primary btn-slimmer dropdown-toggle" type="button"
											data-toggle="dropdown">
										Select an action <span class="caret"></span>
									</button>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="action-btn dropdown-item" target="_blank" href="${this.getSolutionEditRoute(solution)}">
											<i class="far fa-edit mr-2"></i>${this.trans("common.edit")}</a>
										<a href="javascript:void(0)" class="dropdown-item update-btn" data-id="${solution.id}">
											<i class="fas fa-cog mr-2"></i>${this.trans("common.change_status")}</a>
										<a href="javascript:void(0)" class="dropdown-item delete-btn" data-id="${solution.id}">
											<i class="fas fa-trash mr-2"></i>${this.trans("common.delete")}</a>
									</div>
								  </div>`,
					}));
					this.dataTableInstance.rows.add(tableData).draw();
				}
			});
		},
		trans(key) {
			return window.trans(key);
		},
		getBadgeClassForSolutionStatusId(solutionStatusId) {
			// search by id in the solutionStatuses array
			const status = this.solutionStatuses.find((status) => status.id === solutionStatusId);
			return status ? status.badgeCSSClass : "badge-secondary";
		},
		getBadgeTitleForSolutionStatusId(solutionStatusId) {
			const status = this.solutionStatuses.find((status) => status.id === solutionStatusId);
			return status ? status.description : "Unknown status";
		},
		getStatusTitleForSolutionStatusId(solutionStatusId) {
			const status = this.solutionStatuses.find((status) => status.id === solutionStatusId);
			return status ? status.title : "Unknown status";
		},
		getSolutionEditRoute(solution) {
			return window.route("solutions.edit", getLocale(), solution.id);
		},

		openDeleteModal(problem) {
			this.modalProblem = problem;
			this.deleteModal.show();
		},

		openUpdateModal(problem) {
			this.modalProblem = problem;
			this.updateModal.show();
		},

		confirmDelete() {
			if (!this.modalProblem.id) return;
			this.modalActionLoading = true;
			axios
				.delete(window.route("problems.destroy", getLocale(), this.modalProblem.id))
				.then(() => {
					this.getProblemsForFiltering();
					this.modalProblem.id = null;
					this.modalProblem.title = "";
					this.actionSuccessMessage = "Problem deleted successfully!";
					this.showSuccessAlert();
				})
				.catch((error) => {
					this.showErrorMessage(error);
				})
				.finally(() => {
					this.deleteModal.hide();
					this.modalActionLoading = false;
				});
		},
		confirmUpdate() {
			if (!this.modalProblem.id) return;
			this.modalActionLoading = true;
			axios
				.put(location.href + "/update-status/" + this.modalProblem.id, {
					status_id: this.modalProblem.status.id,
				})
				.then(() => {
					this.getProblemsForFiltering();
					this.modalProblem.id = null;
					this.modalProblem.title = "";
					this.actionSuccessMessage = "Problem status updated successfully!";
					this.showSuccessAlert();
				})
				.catch((error) => {
					this.showErrorMessage(error);
				})
				.finally(() => {
					this.updateModal.hide();
					this.modalActionLoading = false;
				});
		},
		showSuccessAlert() {
			const alertElement = document.querySelector("#solutionDeletedAlert");
			alertElement.classList.remove("d-none");
			setTimeout(() => {
				alertElement.classList.add("d-none");
				this.actionSuccessMessage = "";
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
