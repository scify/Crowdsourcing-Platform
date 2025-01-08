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
										>Select a project to view the problems</label
									>
									<div :class="{ 'spinner-border text-primary ml-5': true, hidden: !loading }"></div>
									<select
										id="projectSelect"
										:class="['form-select form-control mt-3', projectsFetched ? '' : 'hidden']"
										v-model="selectedProjectId"
										@change="getProjectProblems"
									>
										<option value="" disabled selected>Select a project</option>
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
				<div class="modal-body" v-if="modalProblem.id">
					<p>
						Are you sure you want to delete the problem
						<b>{{ modalProblem?.default_translation?.title ?? "Untitled" }}</b
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
				<div class="modal-body" v-if="modalProblem.id && problemStatuses.length">
					<p>
						Select a new status for the problem <b>{{ modalProblem.default_translation.title }}</b>
					</p>
					<select class="form-select form-control" v-model="modalProblem.status.id">
						<option v-for="status in problemStatuses" :key="status.id" :value="status.id">
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
	<div class="alert-component position-relative d-none" id="problemDeletedAlert" style="display: flow-root;">
		<div class="alert alert-success" role="alert">
			{{ actionSuccessMessage }}
		</div>
	</div>
	<div class="alert-component position-relative d-none" id="errorAlert" style="display: flow-root;">
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
import CommonModal from "../../../common/ModalComponent.vue";
import { getLocale } from "../../../../common-utils";

export default {
	name: "ProblemsManagement",
	components: { CommonModal },
	data() {
		return {
			fetched: false,
			projects: [],
			selectedProjectId: "",
			problems: [],
			problemStatuses: [],
			errorMessage: "",
			showUnpublishedProblemsOnly: false,
			filteredProblems: [],
			dataTableInstance: null,
			modalProblem: {},
			deleteModal: null,
			updateModal: null,
			modalActionLoading: false,
			actionSuccessMessage: "",
			projectsFetched: false,
		};
	},
	computed: {
		...mapState(["loading", "modal"]),
	},
	async mounted() {
		this.deleteModal = new Modal(document.getElementById("deleteModal"));
		this.updateModal = new Modal(document.getElementById("updateModal"));
		await this.getProblemStatusesForManagementPage();
		await this.getCrowdSourcingProjectsForFiltering();
		await this.setUpDataTable();
	},
	methods: {
		...mapActions(["get", "post", "setLoading"]),

		async setUpDataTable() {
			await this.$nextTick(() => {
				this.dataTableInstance = $("#problemsTable").DataTable({
					pageLength: 5,
					autoWidth: false,
					data: [],
					columns: [
						{ title: "#", data: null, width: "5%" },
						{ title: "Title", data: "title", width: "30%" },
						{ title: "Bookmarks", data: "bookmarks", width: "5%" },
						{ title: "Languages", data: "languages", width: "20%" },
						{ title: "Status", data: "status", width: "20%" },
						{ title: "Actions", data: "actions", width: "20%" },
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
					$("#problemsTable tbody").on("click", `.${action}`, (event) => {
						const problemId = parseInt(event.target.getAttribute("data-id"));
						const problem = this.problems.find((p) => p.id === problemId);
						if (action === "delete-btn") {
							this.openDeleteModal(problem);
						} else if (action === "update-btn") {
							this.openUpdateModal(problem);
						}
					});
				});
			});
		},

		async getProblemStatusesForManagementPage() {
			return this.get({
				url: window.route("api.management.problems.statuses.get"),
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
						this.getProjectProblems();
					}
				})
				.catch((error) => {
					this.showErrorMessage(error);
				});
		},

		getProjectProblems() {
			if (this.selectedProjectId) {
				this.fetched = false;
				this.problems = [];
				this.post({
					url: window.route("api.management.problems.get"),
					data: { projectId: this.selectedProjectId },
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
						title: problem?.default_translation?.title ?? "Untitled",
						bookmarks: problem.bookmarks.length,
						languages: problem.translations
							? problem.translations.map((t) => t.language.language_name).join(", ")
							: "",
						status: `<span title="${this.getBadgeTitleForProblemStatus(problem.status)}"
                                  class="p-2 w-75 badge ${this.getBadgeClassForProblemStatus(problem.status)}">
                                  ${problem.status.title}</span>`,
						actions: `<div class="dropdown">
									<button class="btn btn-primary btn-slimmer dropdown-toggle" type="button"
											data-toggle="dropdown">
										Select an action <span class="caret"></span>
									</button>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="action-btn dropdown-item" target="_blank" href="${this.getAddNewSolutionRoute(problem)}">
												<i class="fa fa-plus mr-2"></i> ${this.trans("problem.add_new_solution")}</a>
										<a class="action-btn dropdown-item" target="_blank" href="${this.getProblemEditRoute(problem)}">
											<i class="far fa-edit mr-2"></i>${this.trans("common.edit")}</a>
										<a href="javascript:void(0)" class="dropdown-item update-btn" data-id="${problem.id}">
											<i class="fas fa-cog mr-2"></i>${this.trans("common.change_status")}</a>
										<a href="javascript:void(0)" class="dropdown-item delete-btn" data-id="${problem.id}">
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
		getBadgeClassForProblemStatus(problemStatus) {
			// search by id in the problemStatuses array
			const status = this.problemStatuses.find((status) => status.id === problemStatus.id);
			return status ? status.badgeCSSClass : "badge-secondary";
		},
		getBadgeTitleForProblemStatus(problemStatus) {
			const status = this.problemStatuses.find((status) => status.id === problemStatus.id);
			return status ? status.description : "Unknown status";
		},
		getAddNewSolutionRoute(problem) {
			return window.route("solutions.create", getLocale()) + "?problem_id=" + problem.id;
		},
		getProblemEditRoute(problem) {
			return window.route("problems.edit", getLocale(), problem.id);
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
					this.getProjectProblems();
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
				.put(window.route("api.problems.update-status", this.modalProblem.id), {
					status_id: this.modalProblem.status.id,
				})
				.then(() => {
					this.getProjectProblems();
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
			const alertElement = document.querySelector("#problemDeletedAlert");
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
