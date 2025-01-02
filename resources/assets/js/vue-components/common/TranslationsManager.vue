<template>
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col text-right">
				<input
					id="extra_translations"
					type="hidden"
					name="extra_translations"
					:value="JSON.stringify(translations)"
				/>

				<div class="d-flex justify-content-end">
					<!-- Language Selector Dropdown -->
					<div class="dropdown">
						<button
							class="btn btn-primary btn-slim dropdown-toggle mr-4"
							type="button"
							id="languageDropdown"
							data-toggle="dropdown"
							aria-expanded="false"
						>
							Select Languages
						</button>
						<ul class="dropdown-menu p-3" aria-labelledby="languageDropdown">
							<li
								v-for="language in availableLanguages"
								:key="'avail_lang_' + language.id"
								class="dropdown-item d-flex align-items-center justify-content-between"
							>
								<label class="mb-0">
									<input
										v-model="checkedLanguages"
										type="checkbox"
										class="form-check-input me-2"
										:value="language"
										@change="checkChanged($event, language)"
									/>
									{{ language.language_name }}
								</label>
								<span v-if="checkedLanguages.includes(language)">
									&#10003;
									<!-- Checkmark icon -->
								</span>
							</li>
						</ul>
					</div>
					<!-- Automatic Translations Button -->
					<button
						:disabled="translationsLoading"
						id="get-automatic-translations-btn"
						type="button"
						class="btn btn-primary btn-slim"
						@click="getAndFillAutomaticTranslations"
						v-if="checkedLanguages.length > 0"
					>
						<span
							v-if="translationsLoading"
							class="loader spinner-border spinner-border-sm"
							role="status"
							aria-hidden="true"
						></span>
						Get Automatic Translations in {{ automaticTranslationLanguageName }}
					</button>
				</div>
				<div
					v-if="showTranslationSuccessMessage"
					class="translation-message-container translation-successful-container mt-3"
				>
					<p class="title font-weight-bold m-0">
						Translation successful for {{ automaticTranslationLanguageName }}. Please review the
						translations and click Save.
					</p>
				</div>
				<div
					v-if="translationErrorMessage"
					class="translation-message-container translation-error-container mt-3"
				>
					<p class="title font-weight-bold m-0">Error: {{ translationErrorMessage }}</p>
				</div>
				<div
					v-if="translationInfoMessage"
					class="translation-message-container translation-info-container mt-3"
				>
					<p class="title font-weight-bold m-0">
						{{ translationInfoMessage }}
					</p>
				</div>
				<div
					v-if="showAlreadyTranslatedTextsMessage"
					class="translation-message-container translation-info-container mt-3"
				>
					<p class="title font-weight-bold m-0">
						All the texts in {{ automaticTranslationLanguageName }} are already translated.
					</p>
				</div>
			</div>
		</div>

		<!-- Rest of your tabs and translations UI remains unchanged -->
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
							:class="{ 'nav-link': true, active: index === activeTabIndex }"
							aria-selected="false"
							role="tab"
							data-toggle="tab"
							:href="'#language-' + translation.language_id"
							:aria-controls="'language-' + translation.language_id"
							@click="clickTab(index)"
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
						:class="{ 'tab-pane fade': true, 'show active': index === activeTabIndex }"
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
									:id="'translation_row_' + getLanguageCode(translation.language_id) + '_' + key"
								>
									<td class="field">
										{{ getDisplayTitleForProperty(key) }}
									</td>
									<td class="original-translation">
										<p class="original-value">{{ originalTranslation[key] }}</p>
									</td>
									<td>
										<textarea
											class="form-control translation-value"
											v-model="translation[key]"
										></textarea>
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
import { computed, onMounted, ref } from "vue";
import { mapActions, useStore } from "vuex";

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
	data() {
		return {
			showAlreadyTranslatedTextsMessage: false,
			showTranslationSuccessMessage: false,
			translationsLoading: false,
			translationErrorMessage: null,
			translationInfoMessage: null,
		};
	},
	setup(props) {
		const store = useStore();
		const translations = ref([]);
		const originalTranslation = ref({});
		const checkedLanguages = ref([]);
		const availableLanguages = ref([]);
		const activeTabIndex = ref(0);
		// make it reactive
		const showAlreadyTranslatedTextsMessage = ref(false);
		const showTranslationSuccessMessage = ref(false);

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
				if (propertyExistsInMetadata(translation[key], key)
					&& translation[key] !== "<p><br></p>"
					&& translation[key] !== "<p>&nbsp;</p>") {
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

		const getLanguageCode = (languageId) => {
			const lang = availableLanguages.value.find((lang) => lang.id === languageId);
			return lang ? lang.language_code : "unknown";
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
			activeTabIndex.value = translations.value.length - 1;
		};

		const checkChanged = ($event, language) => {
			showAlreadyTranslatedTextsMessage.value = false;
			showTranslationSuccessMessage.value = false;

			if ($event.target.checked) addNewTranslation(language);
			else deleteTranslation(language);
		};

		const deleteTranslation = async (language) => {
			const translation = translations.value.find((t) => t.language_id === language.id);
			translations.value.splice(translations.value.indexOf(translation), 1);
			activeTabIndex.value = 0;
		};

		const getOriginalEnglishTranslation = () => {
			return props.existingTranslations.find((t) => t.language_id === props.defaultLangId) || {};
		};

		onMounted(getAvailableLanguagesAndInit);

		const automaticTranslationLanguageName = computed(() => {
			const activeTranslation = translations.value[activeTabIndex.value];
			if (activeTranslation) {
				return getLanguageName(activeTranslation.language_id);
			}
			return "";
		});

		return {
			translations,
			originalTranslation,
			checkedLanguages,
			availableLanguages,
			activeTabIndex,
			getDisplayTitleForProperty,
			getLanguageName,
			getLanguageCode,
			checkChanged,
			filteredTranslations,
			automaticTranslationLanguageName,
		};
	},
	methods: {
		...mapActions(["post"]),
		async getAndFillAutomaticTranslations() {
			this.showAlreadyTranslatedTextsMessage = false;
			this.showTranslationSuccessMessage = false;
			this.translationErrorMessage = null;
			this.translationInfoMessage = null;
			if (this.checkedLanguages.length === 0) {
				this.translationInfoMessage = "Please select at least one language to translate to.";
				return;
			}
			// get the target language code. It is the language code of the active tab.
			// activeTabIndex + 1, because we don't have a tab for the default language,
			// so the translations start from the "second" tab.
			const targetLanguage = this.checkedLanguages[this.activeTabIndex + 1].language_code;
			// for each of the translations in the active tab,
			// we need to get the original value and the translation value for each object that is not already translated.
			// if the translation value is empty,
			// add it to the list of translations to be translated, along with the id of the row.
			// then send the list of translations to the server to be translated
			// and update the translations in the UI.
			const translationsToBeTranslated = [];

			Object.keys(this.translations[this.activeTabIndex]).forEach((key, index) => {
				const translationValue = this.translations[this.activeTabIndex][key];
				if (
					!translationValue &&
					this.originalTranslation[key] !== null &&
					this.originalTranslation[key].length
				) {
					translationsToBeTranslated.push({
						id: key,
						original_text: this.originalTranslation[key],
					});
				}
			});

			if (translationsToBeTranslated.length === 0) {
				this.showAlreadyTranslatedTextsMessage = true;
				return;
			}

			this.performCallAndUpdateTranslations(translationsToBeTranslated, targetLanguage);
		},

		performCallAndUpdateTranslations(translationsToBeTranslated, targetLanguage) {
			this.translationsLoading = true;
			this.showTranslationSuccessMessage = false;
			this.showAlreadyTranslatedTextsMessage = false;
			this.translationInfoMessage = null;
			this.post({
				url: window.route("api.translate.get-automatic-translations"),
				data: { texts: translationsToBeTranslated, target_lang_code: targetLanguage },
				urlRelative: false,
				handleError: false,
			})
				.then((response) => {
					this.showTranslationSuccessMessage = true;
					const translatedTexts = response.data.translated_texts;

					// Update the translations array with the translated texts
					translatedTexts.forEach((translatedText) => {
						this.translations[this.activeTabIndex][translatedText.id] = translatedText.translated_text;
						console.log(`Translation for "${translatedText.id}" is ${translatedText.translated_text}`);
						// get the textarea element and add a class to it to indicate that it has been translated.
						// add a class to the textarea element to indicate that it has been translated.
						const textareaElementParentRow = document.getElementById(
							`translation_row_${targetLanguage}_${translatedText.id}`,
						);
						if (textareaElementParentRow) {
							const textareaElement = textareaElementParentRow.querySelector("textarea");
							textareaElement.classList.add("translated");
						}
					});
				})
				.catch((error) => {
					this.translationErrorMessage = error?.response?.data?.message ?? error.message;
				})
				.finally(() => {
					this.translationsLoading = false;
				});
		},

		clickTab(index) {
			this.showAlreadyTranslatedTextsMessage = false;
			this.showTranslationSuccessMessage = false;
			this.activeTabIndex = index;
		},
	},
};
</script>

<style lang="scss" scoped>
@import "../../../sass/variables";

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

.dropdown-menu {
	max-height: 400px;
	overflow-y: auto;
}

.dropdown-item {
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 0.5rem 1rem;

	label,
	input {
		&:hover {
			cursor: pointer;
		}
	}
}

.dropdown-item span {
	color: $brand-success;
	font-weight: bold;
}

.dropdown-item input[type="checkbox"] {
	margin-right: 8px;
}

.translation-value.translated {
	border: 3px solid $brand-success;
	border-radius: 10px;
}

.translation-message-container {
	color: white;
	padding: 1rem;
	border-radius: 5px;
	float: right;
}

.translation-successful-container {
	background-color: $brand-success;
}

.translation-error-container {
	background-color: $brand-danger;
}

.translation-info-container {
	background-color: $teal;
}

#get-automatic-translations-btn {
	.loader {
		margin-top: -3px;
		margin-right: 5px;
	}
}
</style>
