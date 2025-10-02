<template>
	<div>
		<div class="container-fluid px-0">
			<div class="row px-0">
				<div class="col">
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Campaigns Problems Solutions</h3>
						</div>
						<div class="card-body">
							<div class="container-fluid px-0">
								<div class="row px-0 mb-3">
									<div class="col-12">
										<label for="projectSelect" class="form-label mb-0"
											>Select a campaign to view the solutions</label
										>
										<div
											:class="{
												'spinner-border text-primary ml-5': true,
												hidden: !projectsLoading,
											}"
										></div>
										<select
											id="projectSelect"
											v-model="selectedProjectId"
											:class="['form-select form-control mt-3', projectsFetched ? '' : 'hidden']"
											@change="getProblemsAndSolutionsForProject"
										>
											<option value="" disabled selected>Select a campaign</option>
											<option v-for="project in projects" :key="project.id" :value="project.id">
												{{ project.default_translation.name }}
											</option>
										</select>
									</div>
								</div>
								<!-- Campaign Voting Statistics Section -->
								<div :class="['row px-0 mb-3', selectedProjectId && statisticsFetched ? '' : 'hidden']">
									<div class="col-12">
										<div class="card card-info">
											<div class="card-header">
												<h3 class="card-title">Campaign Voting Statistics</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-md-3 col-sm-6">
														<div class="info-box">
															<span class="info-box-icon bg-info"
																><i class="fas fa-users"></i
															></span>
															<div class="info-box-content">
																<span class="info-box-text">Number of Voters</span>
																<span class="info-box-number">{{
																	statistics.voters_count || 0
																}}</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div :class="['row px-0 mb-3', selectedProjectId ? '' : 'hidden']">
									<div class="col-12">
										<label for="problemSelect" class="form-label mb-0"
											>Select a problem to further filter the solutions</label
										>
										<div
											:class="{
												'spinner-border text-primary ml-5': true,
												hidden: !problemsLoading,
											}"
										></div>
										<select
											id="problemSelect"
											v-model="selectedProblemId"
											:class="['form-select form-control mt-3', problemsFetched ? '' : 'hidden']"
											@change="getFilteredSolutions"
										>
											<option value="" disabled selected>Select a problem</option>
											<option value="all">View all solutions</option>
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
												id="filterUnpublishedSolutions"
												class="form-check-input"
												type="checkbox"
												@change="toggleShowUnpublishedSolutions"
											/>
											<label class="form-check-label" for="filterUnpublishedSolutions">
												Show only unpublished solutions
											</label>
										</div>
									</div>
								</div>
								<div :class="['row px-0 mb-3', selectedProjectId ? '' : 'hidden']">
									<div class="col-12">
										<button
											class="btn btn-primary btn-slim"
											:disabled="solutionsLoading"
											@click="exportSolutions"
										>
											Export Solutions
										</button>
									</div>
								</div>
								<div class="row px-0 mb-3">
									<div class="col text-center">
										<div
											:class="{
												'spinner-border text-primary ml-5': true,
												hidden: !solutionsLoading,
											}"
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
										<div class="alert alert-warning">
											No solutions found for the selected filters
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Delete Confirmation Modal -->
		<div id="deleteModal" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 id="deleteModalLabel" class="modal-title">Confirm Delete</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div v-if="modalSolution.id" class="modal-body">
						<p>
							Are you sure you want to delete the solution
							<b>{{ modalSolution?.default_translation?.title ?? "Untitled" }}</b
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
							:disabled="modalActionLoading"
							@click="confirmDelete"
						>
							<span
								:class="['spinner-border spinner-border-sm mr-2', { 'd-none': !modalActionLoading }]"
								role="status"
								aria-hidden="true"
							></span
							>I understand, Delete the solution
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Update Solution Status Modal -->
		<div id="updateModal" class="modal fade" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 id="updateModalLabel" class="modal-title">Update Solution Status</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div v-if="modalSolution.id && solutionStatuses.length" class="modal-body">
						<p>
							Select a new status for the solution
							<b>{{ modalSolution?.default_translation?.title ?? "Untitled" }}</b>
						</p>
						<select v-model="modalSolution.status.id" class="form-select form-control">
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
							:disabled="modalActionLoading"
							@click="confirmUpdate"
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
		<div id="solutionDeletedAlert" class="alert-component position-relative d-none">
			<div class="alert alert-success" role="alert">
				{{ actionSuccessMessage }}
			</div>
		</div>
		<div id="errorAlert" class="alert-component position-relative d-none">
			<div class="alert alert-danger" role="alert">
				{{ errorMessage }}
			</div>
		</div>
	</div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import $ from "jquery";
import "datatables.net";
import Modal from "bootstrap/js/dist/modal";
import axios from "axios";
import { getLocale } from "../../../../common-utils";

export default {
	name: "SolutionsManagement",
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
			modalSolution: {},
			deleteModal: null,
			updateModal: null,
			modalActionLoading: false,
			actionSuccessMessage: "",
			projectsFetched: false,
			problemsFetched: false,
			solutionsLoading: false,
			projectsLoading: false,
			problemsLoading: false,
			statisticsFetched: false,
			statisticsLoading: false,
			statistics: {},
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
			// eslint-disable-next-line vue/valid-next-tick
			await this.$nextTick(() => {
				this.dataTableInstance = $("#solutionsTable").DataTable({
					pageLength: 5,
					autoWidth: false,
					data: [],
					order: [[3, "desc"]], // Order by upvotes column (index 3) in descending order
					columns: [
						{ title: "#", data: null, width: "5%" },
						{
							title: "Title",
							data: null,
							width: "10%",
							render: function (data, type, row) {
								return row.default_translation?.title ?? "Untitled";
							},
						},
						{
							title: "Description",
							data: null,
							width: "30%",
							render: function (data, type, row) {
								return row.default_translation?.description ?? "No description";
							},
						},
						{ title: "Upvotes", data: "upvotes", width: "5%" },
						{ title: "Languages", data: "languages", width: "20%" },
						{ title: "Author", data: "user", width: "10%" },
						{ title: "Status", data: "status", width: "10%" },
						{ title: "Actions", data: "actions", width: "10%" },
					],
					columnDefs: [
						{
							targets: 0,
							render: (data, type, row, meta) => meta.row + 1,
						},
						{
							targets: [0, 3, 5, 6, 7], // Indices of columns to center
							className: "text-center",
						},
					],
				});

				// Event listener for action items clicks
				const actions = ["delete-btn", "update-btn", "admin-upvote-btn", "admin-downvote-btn"];
				actions.forEach((action) => {
					$("#solutionsTable tbody").on("click", `.${action}`, (event) => {
						const solutionId = parseInt(event.target.getAttribute("data-id"));
						const solution = this.solutions.find((p) => p.id === solutionId);
						if (action === "delete-btn") {
							this.openDeleteModal(solution);
						} else if (action === "update-btn") {
							this.openUpdateModal(solution);
						} else if (action === "admin-upvote-btn") {
							this.adminUpvoteSolution(solution);
						} else if (action === "admin-downvote-btn") {
							this.adminDownvoteSolution(solution);
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
						this.getProblemsAndSolutionsForProject();
					}
				})
				.catch((error) => {
					this.showErrorMessage(error);
				})
				.finally(() => {
					this.projectsLoading = false;
				});
		},

		getProblemsAndSolutionsForProject() {
			this.problemsLoading = true;
			if (this.selectedProjectId) {
				this.problemsFetched = false;
				this.statisticsFetched = false;
				this.problems = [];
				this.statistics = {};

				// Get problems
				this.post({
					url: window.route("api.management.solutions.problems.get"),
					data: { projectId: this.selectedProjectId },
					urlRelative: false,
				})
					.then((response) => {
						this.problems = response.data;
						this.problemsFetched = true;
						this.getFilteredSolutions();
					})
					.catch((error) => {
						this.showErrorMessage(error);
					})
					.finally(() => {
						this.problemsLoading = false;
					});

				// Get voting statistics
				this.getCampaignVotingStatistics();
			}
		},

		async getCampaignVotingStatistics() {
			if (!this.selectedProjectId) return;

			this.statisticsLoading = true;
			this.get({
				url: window.route("api.projects.voting-statistics.get", this.selectedProjectId),
				data: {},
				urlRelative: false,
			})
				.then((response) => {
					this.statistics = response.data;
					this.statisticsFetched = true;
				})
				.catch((error) => {
					this.showErrorMessage(error);
				})
				.finally(() => {
					this.statisticsLoading = false;
				});
		},

		async getFilteredSolutions() {
			if (this.projects.length || this.problems.length) {
				this.fetched = false;
				this.solutionsLoading = true;
				this.solutions = [];
				const data = {
					filters: {
						projectFilters: this.selectedProjectId
							? [this.selectedProjectId]
							: this.projects.map((x) => x.id),
						problemFilters:
							this.selectedProblemId && this.selectedProblemId !== "all"
								? [this.selectedProblemId]
								: this.problems.map((x) => x.id),
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

		async updateDataTable() {
			// eslint-disable-next-line vue/valid-next-tick
			await this.$nextTick(() => {
				if (this.dataTableInstance) {
					this.dataTableInstance.clear();
					const tableData = this.filteredSolutions.map((solution, index) => ({
						...solution, // Pass the raw solution object
						upvotes: solution.upvotes_count,
						languages: solution.translations
							? solution.translations.map((t) => t.language.language_name).join(", ")
							: "",
						user: solution?.creator
							? solution.creator?.nickname + " (" + solution.creator.email + ")"
							: "N/A",
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
										<a href="javascript:void(0)" class="dropdown-item admin-upvote-btn" data-id="${solution.id}">
											<i class="fas fa-thumbs-up mr-2"></i>Admin Upvote</a>
										<a href="javascript:void(0)" class="dropdown-item admin-downvote-btn" data-id="${solution.id}">
											<i class="fas fa-thumbs-down mr-2"></i>Admin Downvote</a>
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

		openDeleteModal(solution) {
			this.modalSolution = solution;
			this.deleteModal.show();
		},

		openUpdateModal(solution) {
			this.modalSolution = solution;
			this.updateModal.show();
		},

		confirmDelete() {
			if (!this.modalSolution.id) return;
			this.modalActionLoading = true;
			axios
				.delete(window.route("solutions.destroy", getLocale(), this.modalSolution.id))
				.then(() => {
					this.getFilteredSolutions();
					this.modalSolution.id = null;
					this.modalSolution.title = "";
					this.actionSuccessMessage = "Solution deleted successfully!";
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
			if (!this.modalSolution.id) return;
			this.modalActionLoading = true;
			axios
				.put(window.route("api.solutions.update-status", this.modalSolution.id), {
					status_id: this.modalSolution.status.id,
				})
				.then(() => {
					this.getFilteredSolutions();
					this.modalSolution.id = null;
					this.modalSolution.title = "";
					this.actionSuccessMessage = "Solution status updated successfully!";
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

		adminUpvoteSolution(solution) {
			// Use the admin-specific endpoint that bypasses vote limits
			axios
				.post(window.route("api.solutions.admin-add-vote", solution.id))
				.then(() => {
					// Increment locally without refetching the entire list
					solution.upvotes_count = (solution.upvotes_count || 0) + 1;
					this.updateVotesCell(solution.id, solution.upvotes_count);
					this.actionSuccessMessage = "Solution upvoted successfully!";
					this.showSuccessAlert();
				})
				.catch((error) => {
					this.showErrorMessage(error);
				});
		},

		adminDownvoteSolution(solution) {
			// Use the existing vote functionality to remove a vote
			axios
				.post(window.route("api.solutions.vote-downvote"), {
					solution_id: solution.id,
				})
				.then(() => {
					// Decrement locally without refetching; do not drop below zero
					solution.upvotes_count = Math.max(0, (solution.upvotes_count || 0) - 1);
					this.updateVotesCell(solution.id, solution.upvotes_count);
					this.actionSuccessMessage = "Solution downvoted successfully!";
					this.showSuccessAlert();
				})
				.catch((error) => {
					this.showErrorMessage(error);
				});
		},

		exportSolutions() {
			const url = window.route("api.solutions.export", this.selectedProjectId);

			axios
				.get(url, { responseType: "blob" })
				.then((response) => {
					const blob = new Blob([response.data], { type: "text/csv" });
					const link = document.createElement("a");
					link.href = URL.createObjectURL(blob);
					link.download = `solutions_${this.selectedProjectId}.csv`;
					document.body.appendChild(link);
					link.click();
					document.body.removeChild(link);
				})
				.catch((error) => {
					this.showErrorMessage(error);
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

		// Update only the votes cell in the DataTable for the given solution id
		updateVotesCell(solutionId, newCount) {
			if (!this.dataTableInstance) return;
			const table = this.dataTableInstance;
			// Find the row index by matching the raw solution object id stored in the row data
			const rowIndexes = table.rows().indexes().toArray();
			let targetIndex = null;
			for (const idx of rowIndexes) {
				const rowData = table.row(idx).data();
				if (rowData && rowData.id === solutionId) {
					targetIndex = idx;
					break;
				}
			}
			if (targetIndex === null) return;
			// Upvotes column index is 3 (0-based) as defined in setUpDataTable()
			table.cell(targetIndex, 3).data(newCount);
			// Keep paging and ordering; do a minimal redraw
			table.draw(false);
		},
	},
};
</script>
