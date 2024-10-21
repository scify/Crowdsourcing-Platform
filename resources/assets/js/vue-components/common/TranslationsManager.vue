<template>
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col">
				<input
					id="extra_translations"
					type="hidden"
					name="extra_translations"
					:value="JSON.stringify(translations)"
				/>

				<div
					v-for="language in availableLanguages"
					:key="'avail_lang_' + language.id"
					class="float-left mr-2 lang"
				>
					<label v-if="language?.id !== defaultLangId">
						<input
							v-model="checkedLanguages"
							type="checkbox"
							:value="language"
							@change="checkChanged($event, language)"
						/>
						{{ language.language_name }}
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<ul id="translations-tab" class="nav nav-tabs mt-4" role="tablist">
					<li
						v-for="(translation, index) in translations"
						:key="'translation_item_' + index"
						class="nav-item"
						role="presentation"
					>
						<a
							:id="'language-' + translation.language_id + '-tab'"
							:class="{ 'nav-link': true, active: index === 0 }"
							aria-selected="false"
							role="tab"
							data-toggle="tab"
							:href="'#language-' + translation.language_id"
							:aria-controls="'language-' + translation.language_id"
						>
							{{ getLanguageName(translation.language_id) }}</a
						>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div id="translation_tabs" class="tab-content">
					<div
						v-for="(translation, index) in translations"
						:id="'language-' + translation.language_id"
						:key="'translation_' + index"
						:class="{ 'tab-pane fade': true, 'show active': index === 0 }"
						role="tabpanel"
						:aria-labelledby="'language-' + translation.language_id + '-tab'"
					>
						<table class="table table-striped">
							<thead>
							<tr>
								<th scope="col">Field</th>
								<th scope="col">Original Language ({{ getLanguageName(defaultLangId) }})</th>
								<th scope="col">
									Translation in
									{{ getLanguageName(translation.language_id) }}
								</th>
							</tr>
							</thead>
							<tbody>
							<tr
								v-for="(value, key) in filteredTranslations(translation)"
								:key="'translation_row_' + key"
								:id="'translation_row_' + value"
							>
								<td class="field">
									{{ getDisplayTitleForProperty(key) }}
								</td>
								<td class="original-translation">
									{{ originalTranslation[key] }}
								</td>
								<td>
									<textarea v-model="translation[key]"></textarea>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useStore } from "vuex";

export default {
	name: "TranslationsManager",
	props: {
		existingTranslations: {
			type: Array,
			default: () => [],
		},
		modelMetaData: {
			type: Object,
			default: () => ({}),
		},
		defaultLangId: {
			type: [String, Number],
			default: "",
		},
	},
	setup(props) {
		const store = useStore();
		const translations = ref([]);
		const originalTranslation = ref({});
		const checkedLanguages = ref([]);
		const availableLanguages = ref([]);

		const getAvailableLanguagesAndInit = async () => {
			try {
				const response = await store.dispatch("get", {
					url: window.route("api.languages.get"),
					data: {},
					urlRelative: false,
				});
				availableLanguages.value = response.data.languages;
				translations.value = getTranslationsWithoutTheDefault();
				originalTranslation.value = getOriginalEnglishTranslation();
				checkedLanguages.value = getAlreadySelectedLanguages();
			} catch (error) {
				store.dispatch("handleError", error);
			}
		};

		const getDisplayTitleForProperty = (property) => {
			return props.modelMetaData[property]?.display_title || "Unknown";
		};

		const propertyExistsInMetadata = (value, key) => {
			return props.modelMetaData[key] !== undefined;
		};

		const filteredTranslations = (translation) => {
			// return an object with only the properties that exist in the model metadata
			return Object.keys(translation).reduce((acc, key) => {
				if (propertyExistsInMetadata(translation[key], key)) {
					acc[key] = translation[key];
				}
				return acc;
			}, {});
		};

		const getAlreadySelectedLanguages = () => {
			const checkedLanguagesList = [];
			if (!Array.isArray(props.existingTranslations) || props.existingTranslations.length === 0)
				return checkedLanguagesList;
			availableLanguages.value.forEach((lang) => {
				const result = props.existingTranslations.find((translation) => translation.language_id === lang.id);
				if (result) checkedLanguagesList.push(lang);
			});
			return checkedLanguagesList;
		};

		const getTranslationsWithoutTheDefault = () => {
			return props.existingTranslations.filter((t) => t.language_id !== props.defaultLangId);
		};

		const getLanguageName = (languageId) => {
			const lang = availableLanguages.value.find((lang) => lang.id === languageId);
			return lang ? lang.language_name : "Unknown";
		};

		const addNewTranslation = (language) => {
			const copy = { ...originalTranslation.value };
			for (const property in copy) {
				if (typeof copy[property] === "string" || copy[property] instanceof String) {
					copy[property] = null;
				}
			}
			copy.language_id = language.id;
			translations.value.push(copy);
		};

		const checkChanged = ($event, language) => {
			if ($event.target.checked) addNewTranslation(language);
			else deleteTranslation(language);
		};

		const deleteTranslation = async (language) => {
			const translation = translations.value.find((t) => t.language_id === language.id);
			const swal = (await import("bootstrap-sweetalert")).default;
			swal(
				{
					title: "Are you sure?",
					text: "The translation will be deleted",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, delete it!",
					cancelButtonText: "No, cancel!",
					closeOnConfirm: true,
					closeOnCancel: true,
				},
				(isConfirm) => {
					if (isConfirm) {
						translations.value.splice(translations.value.indexOf(translation), 1);
					} else {
						checkedLanguages.value.push(language);
					}
				},
			);
		};

		const getOriginalEnglishTranslation = () => {
			return props.existingTranslations.find((t) => t.language_id === props.defaultLangId) || {};
		};

		onMounted(getAvailableLanguagesAndInit);

		return {
			translations,
			originalTranslation,
			checkedLanguages,
			availableLanguages,
			getDisplayTitleForProperty,
			getLanguageName,
			checkChanged,
			filteredTranslations,
		};
	},
};
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

.lang {
	width: 120px;
}
</style>
