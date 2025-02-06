<template>
	<div class="modal-component">
		<common-modal :open="modalOpen" :allow-close="false">
			<template #header>
				<h5 class="modal-title pl-2">
					Mark Questionnaire Languages<span
						v-if="contentLoading"
						class="spinner-border spinner-border-sm ml-2"
						role="status"
						aria-hidden="true"
					></span>
				</h5>
			</template>
			<template #body>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col">
							<table class="table table-striped w-100">
								<thead>
									<tr class="d-flex">
										<th class="col-8">Language</th>
										<th class="col-4 text-center">Human approved</th>
									</tr>
								</thead>
								<tbody>
									<tr
										v-for="(questionnaireLang, index) in questionnaireLanguages"
										:key="index"
										class="d-flex"
									>
										<td class="col-8">
											{{ questionnaireLang.language.language_name }}
										</td>
										<td class="col-4 text-center">
											<input
												v-model="questionnaireLang.human_approved"
												class="form-check-input"
												type="checkbox"
											/>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</template>
			<template #footer>
				<div class="container-fluid">
					<div class="row">
						<div class="col-3 offset-6 pr-0">
							<button
								type="button"
								class="btn btn-outline-secondary btn-slim w-100"
								@click="$emit('canceled')"
							>
								Cancel
							</button>
						</div>
						<div class="col-3 pr-0">
							<button
								:disabled="saveLoading"
								type="button"
								class="btn btn-primary btn-slim w-100"
								@click="saveQuestionnaireLanguagesStatus"
							>
								Save<span
									v-if="saveLoading"
									class="spinner-border spinner-border-sm ml-2"
									role="status"
									aria-hidden="true"
								></span>
							</button>
						</div>
					</div>
				</div>
			</template>
		</common-modal>
	</div>
</template>

<script>
import { defineComponent } from "vue";
import { mapActions } from "vuex";
import { showToast } from "../../common-utils";
import CommonModal from "../common/ModalComponent.vue";

export default defineComponent({
	name: "QuestionnaireLanguages",
	components: {
		CommonModal,
	},
	props: {
		modalOpen: {
			type: Boolean,
			default: false,
		},
		questionnaireId: {
			type: Number,
			default: null,
		},
	},
	data() {
		return {
			questionnaireLanguages: [],
			saveLoading: false,
			contentLoading: false,
		};
	},
	watch: {
		modalOpen: {
			handler(val) {
				if (val) {
					this.getQuestionnaireLanguages();
				}
			},
			immediate: true,
		},
	},
	methods: {
		...mapActions(["get", "handleError", "post"]),
		async getQuestionnaireLanguages() {
			this.contentLoading = true;
			try {
				const response = await this.get({
					url: window.route("api.questionnaire.languages.get") + "?questionnaire_id=" + this.questionnaireId,
					urlRelative: false,
				});
				this.questionnaireLanguages = response.data.questionnaire_languages;
			} catch (error) {
				this.handleError(error);
			} finally {
				this.contentLoading = false;
			}
		},
		async saveQuestionnaireLanguagesStatus() {
			this.saveLoading = true;
			const mapped = this.questionnaireLanguages.map((el) => ({
				id: el.language.id,
				status: el.human_approved,
			}));
			try {
				await this.post({
					url: window.route("api.questionnaire.translations.mark"),
					data: {
						questionnaire_id: this.questionnaireId,
						lang_ids_to_status: mapped,
					},
					urlRelative: false,
				});
				showToast("Languages updated!", "#28a745");
			} catch (error) {
				this.handleError(error);
			} finally {
				this.saveLoading = false;
			}
		},
	},
});
</script>

<style scoped></style>
