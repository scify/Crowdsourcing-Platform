<template>
  <div class="modal-component">
    <common-modal
        :open="modalOpen"
        :allow-close="true"
        :classes="''"
        @canceled="$emit('canceled')">
      <template v-slot:header>
        <h5 class="modal-title pl-2">Mark Questionnaire Languages<span v-if="contentLoading"
                                                                       class="spinner-border spinner-border-sm ml-2"
                                                                       role="status"
                                                                       aria-hidden="true"></span></h5>
      </template>
      <template v-slot:body>
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
                <tr class="d-flex" v-for="(questionnaireLang, index) in questionnaireLanguages" :key="index">
                  <td class="col-8">
                    {{ questionnaireLang.language.language_name }}
                  </td>
                  <td class="col-4 text-center">
                    <input class="form-check-input" type="checkbox" v-model="questionnaireLang.human_approved">
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </template>
      <template v-slot:footer>
        <div class="container-fluid">
          <div class="row">
            <div class="col-3 offset-6 pr-0">
              <button type="button" class="btn btn-outline-secondary btn-lg w-100"
                      @click="$emit('canceled')">
                Cancel
              </button>
            </div>
            <div class="col-3 pr-0">
              <button
                  :disabled="saveLoading"
                  type="button" class="btn btn-primary btn-lg w-100"
                  @click="saveQuestionnaireLanguagesStatus">
                Save<span v-if="saveLoading" class="spinner-border spinner-border-sm ml-2"
                          role="status"
                          aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </div>
      </template>
    </common-modal>
  </div>
</template>

<script>

import {mapActions} from "vuex";
import _ from "lodash";
import {showToast} from "../../common-utils";
import CommonModal from "../common/ModalComponent";

export default {
	name: "QuestionnaireLanguages",
	components: {
		CommonModal
	},
	props: {
		modalOpen: {
			type: Boolean,
			default: false,
		},
		questionnaireId: null
	},
	data: function () {
		return {
			questionnaireLanguages: [],
			saveLoading: false,
			contentLoading: false
		};
	},
	watch: {
		"modalOpen"() {
			if (this.modalOpen)
				this.getQuestionnaireLanguages();
		}
	},
	methods: {
		...mapActions([
			"get",
			"handleError",
			"post"
		]),
		getQuestionnaireLanguages() {
			this.contentLoading = true;
			this.get({
				url: window.route("questionnaire.languages") + "?questionnaire_id=" + this.questionnaireId,
				urlRelative: false
			}).then(response => {
				this.questionnaireLanguages = response.data.questionnaire_languages;
				this.contentLoading = false;
			});
		},
		saveQuestionnaireLanguagesStatus() {
			this.saveLoading = true;
			const mapped = _.map(this.questionnaireLanguages, function f(el) {
				return {
					id: el.language.id,
					status: el.human_approved
				};
			});
			this.post({
				url: window.route("questionnaire.mark-translations"),
				data: {
					questionnaire_id: this.questionnaireId,
					lang_ids_to_status: mapped
				},
				urlRelative: false
			}).then(() => {
				this.saveLoading = false;
				showToast("Languages updated!", "#28a745");
			});
		}
	}
};
</script>

<style scoped>

</style>
