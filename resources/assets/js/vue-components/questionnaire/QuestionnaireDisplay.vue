<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="language-select">Select language</label>
          <select class="form-control" @change="onLanguageChange($event)" id="language-select">
            <option :selected="language.code === 'en'"
                    :value="language.code" v-for="(language, index) in surveyLocales"
                    :key="index">
              {{language.name}}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="survey-container">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import * as Survey from "survey-knockout";
import LanguageService from "./languageService";

export default {
  created() {
    this.languageService = new LanguageService();
  },
  mounted() {
    this.initQuestionnaireDisplay();
  },
  props: {
    questionnaire: {
      type: Object,
      default: function () {
        return {}
      }
    },
    languages: []
  },
  data: function () {
    return {
      surveyCreator: null,
      survey: null,
      languageService: null,
      surveyLocales: []
    }
  },
  methods: {
    ...mapActions([
      'get',
      'handleError',
      'post'
    ]),
    initQuestionnaireDisplay() {
      Survey.StylesManager.applyTheme("modern");
      this.survey = new Survey.Model(this.questionnaire.questionnaire_json);
      this.survey.locale = 'en';
      const locales = this.survey.getUsedLocales();
      // show English as the first language
      this.arraymove(locales, locales.indexOf("en"), 0);
      console.log(locales);
      for (let i = 0; i < locales.length; i++) {
        this.surveyLocales.push({
          code: locales[i],
          name: this.getLanguageFromCode(locales[i]).language_name
        });
      }
      this.survey.onComplete.add(this.saveQuestionnaireResponse);
      this.survey.render("survey-container");
    },
    saveQuestionnaireResponse(sender) {
      const resultAsString = sender.data;
      console.log(resultAsString);
    },
    onLanguageChange(event) {
      this.survey.locale = event.target.value;
    },
    arraymove(arr, fromIndex, toIndex) {
      const element = arr[fromIndex];
      arr.splice(fromIndex, 1);
      arr.splice(toIndex, 0, element);
    },
    getLanguageFromCode(code) {
      return _.find(this.languages, function(l) { return l.language_code === code; })
    }
  }
}
</script>

<style lang="scss">
@import "resources/assets/sass/variables";
@import "~survey-jquery/modern.min.css";

#survey-container {
  .sv-btn.sv-footer__complete-btn, .sv-btn.sv-footer__next-btn, .sv-btn.sv-footer__prev-btn {
    background-color: $brand-primary;
    float: left;
    border-radius: 3px;
    font-size: 20px;
    font-weight: 500;
    line-height: 1.7em;
    border: 2px solid white;
  }

  .sv-page.sv-body__page, .sv-footer {
    margin-left: 0;
    margin-right: 0;
  }
}

</style>
