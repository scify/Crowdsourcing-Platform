<template>
  <div>
    <!--    TODO: ITERATE TO ALL LANGUAGES AND CREATE CHECKBOXES. USER SHOULD BE ABLE TO SELECT THE LANGUAGE-->

    <!-- TODO:  WHEN A LANGUAGE IS ADDED, THE TRANSLATIONS SHOULD BE ENRICHED.-->
    <ul class="nav nav-tabs mt-4" id="translations-tab" role="tablist">
      <li v-for="(translation, index) in this.translations"
          class="nav-item"
          role="presentation">
        <a
            v-bind:class="{'nav-link' : true , 'active':(index ===0)}"
            aria-selected="false"
            role="tab"
            data-toggle="tab"
            :id="'language-'+translation.language_id+'-tab'"
            :href="'#language-'+translation.language_id"
            :aria-controls="'language-'+translation.language_id"
        > {{ getLanguageName(translation.language_id) }}</a>
      </li>
    </ul>
    <div class="tab-content " id="translation_tabs">
      <div v-for="(translation,index) in this.translations"
           v-bind:class="{'tab-pane fade' : true , 'show active': (index ===0)}"
           role="tabpanel"
           :id="'language-'+translation.language_id"
           :aria-labelledby="'language-'+translation.language_id+'-tab'">
        <table class="table table-striped">
          <thead>
          <tr>
            <th scope="col">Field</th>
            <th scope="col">Original Translation</th>
            <th scope="col">{{ getLanguageName(translation.language_id) }}</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td class="field">Project Name (*)</td>
            <td class="original-translation">{{ originalTranslation.name }}</td>
            <td>

              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field">Project Description (*)</td>
            <td class="original-translation">
              {{ originalTranslation.description }}
            </td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field">Project Motto Title (*)</td>
            <td class="original-translation">
              {{ originalTranslation.motto_title }}
            </td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field">Project Motto Subtitle</td>
            <td class="original-translation">
              {{ originalTranslation.motto_subtitle }}
            </td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field"> About Text (*)</td>
            <td class="original-translation"> {{ originalTranslation.about }}</td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field"> Footer Text (*)</td>
            <td class="original-translation"> {{ originalTranslation.footer }}</td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field"> Social Media Title</td>
            <td class="original-translation">
              {{ originalTranslation.sm_title }}
            </td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field"> Social Media Description</td>
            <td class="original-translation">
              {{ originalTranslation.sm_description }}
            </td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field"> Social Media Keywords</td>
            <td class="original-translation">
              {{ originalTranslation.sm_keywords }}
            </td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field"> Congratulations email intro text</td>
            <td class="original-translation">
              {{ originalTranslation.questionnaire_response_email_intro_text }}

            </td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          <tr>
            <td class="field"> Congratulations email outro text</td>
            <td class="original-translation">
              {{ originalTranslation.questionnaire_response_email_outro_text }}
            </td>
            <td>
              <textarea></textarea>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ["existingTranslations", "availableLanguages"],
  data: function () {
    return {
      translations: this.removeOriginalEngishTranslation(), //todo: use initModel instead
      originalTranslation: this.getOriginalTranslation()
    }
  },

  methods: {
    removeOriginalEngishTranslation(){
      let translations=[];
      this.$props.existingTranslations.forEach(function(t){
        if (t.language_id !=6)
          translations.push(t);
      });
      return translations;
    },
    initModel() {
      // TO BE IMPLEMENTED if translatiosn have this form
      let model = {
        "el": {
          "language_id": 6,
          "name": "name",
          "motto_title": "moto",
          "motto_subtitle": "subtitle",
          "description": "descritpion",
          "about": "about",
          "footer": "footer",
          "sm_title": "sm title",
          "sm_description": "sm descr",
          "sm_keywords": "sm keywords"
        },
        "bg": {
          "language_id": 6,
          "name": "name",
          "motto_title": "moto",
          "motto_subtitle": "subtitle",
          "description": "descritpion",
          "about": "about",
          "footer": "footer",
          "sm_title": "sm title",
          "sm_description": "sm descr",
          "sm_keywords": "sm keywords"
        }
      }
      //then we can bind them to the textareas like
      // v-model = translations[languageCode].about
      // v-model = translations[languageCode].moto
      // v-model = translations[languageCode].footer
      // and so on
      return model;
    },
    getLanguageName(languageId) {
      //find the name from availableLanguages
      return "Language" + languageId;
    }
    ,
    addNewTranslation(languageId) {
      //copy the first translation, empty the values and set the language id
    }
    ,
    getOriginalTranslation() {
      // let filterResults =  this.translations.filter((item) => item.language_id ==6);
      // console.log(filterResults);
      let originalTranslation =null;
      this.$props.existingTranslations.forEach(function(t){
        if (t.language_id ==6)
          originalTranslation = t;
      });
      return originalTranslation;
    }

  }
}
</script>

<style lang="scss" scoped>
@import "resources/assets/sass/variables";

.table .field {
  max-width: 60px;

}
textarea{
  width:100%;
  min-height:30px;
}
.table .original-translation {
  max-width: 300px;
}

</style>
