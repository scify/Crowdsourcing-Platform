<template>
  <div>

    <input type="hidden" name="extra_project_translations" :value="JSON.stringify(this.translations)"/>

    <div v-for="(language) in availableLanguages"
         v-if="language.id !==6">
      <label>
        <input type="checkbox"
               :value="language"
               v-model="checkedLanguages"
               @change="checkChanged($event,language)">
        {{ language.language_name }}
      </label>
    </div>

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
          <tr v-for="(value, property) in translation"
              v-if="modelMetaData[property]"
          >
            <td class="field">{{ getDisplayTitleForProperty(property) }}</td>
            <td class="original-translation">{{ originalTranslation[property] }}</td>
            <td>
              <textarea v-model="translation[property]"></textarea>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>

import _ from "lodash";

export default {
  props: ["existingTranslations", "availableLanguages", "modelMetaData"],
  data: function () {
    return {
      translations: this.removeOriginalEngishTranslation(),
      originalTranslation: this.getOriginalEnglishTranslation(),
      checkedLanguages: this.getAlreadySelectedLanguages()
    }
  },

  methods: {
    getDisplayTitleForProperty(property){
      return this.modelMetaData[property].display_title;
    },
    getAlreadySelectedLanguages() {
      var checkedLanguages = [];
      _.filter(this.$props.availableLanguages, (lang) => {
        // if you can find in the translations.
        var result = _.find(this.existingTranslations, {"language_id": lang.id});
        if (result)
          checkedLanguages.push(lang);
      });
      return checkedLanguages;
    },
    removeOriginalEngishTranslation() {
      let translations = [];
      this.$props.existingTranslations.forEach(function (t) {
        if (t.language_id != 6)
          translations.push(t);
      });
      return translations;
    },
    getLanguageName(languageId) {
      //find the name from availableLanguages
      let lang = _.find(this.$props.availableLanguages, {"id": languageId});
      return lang.language_name;
    },
    addNewTranslation(language) {
      //copy the original translation
      var copy = {...this.originalTranslation}
      for (const property in copy) {
        if (typeof property === 'string' || property instanceof String) {
          copy[property] = null;
        }
      }
      //WE MAKE THE ASSUMPTIONS THAT THE VIEWMODEL PASSED TO THIS COMPONENT HAS
      // THE DATABASE ID as "id"
      //  id : the database id
      copy.language_id = language.id;
      copy.id = 0;

      this.translations.push(copy);
    },
    checkChanged($event, language) {
      console.log($event, language);

      if ($event.target.checked)
        this.addNewTranslation(language);
      else
        this.deleteTranslation(language);

    },
    deleteTranslation(language) {
      let translation = _.find(this.translations, {"language_id": language.id});
      let instance = this;
      window.swal({
            title: "Are you sure?",
            text: "The translation will be deleted",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function (isConfirm) {
            if (isConfirm) {
              instance.translations.splice(instance.translations.indexOf(translation), 1);
            } else               //restore the checked option
              instance.checkedLanguages.push(language);
          });
    },
    getOriginalEnglishTranslation() {
      return _.find(this.$props.existingTranslations, {"language_id": 6});
    }

  }
}
</script>

<style lang="scss" scoped>
@import "resources/assets/sass/variables";

.table .field {
  max-width: 60px;

}

textarea {
  width: 100%;
  min-height: 30px;
}

.table .original-translation {
  max-width: 300px;
}

</style>
