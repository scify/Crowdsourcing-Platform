<a target="_blank"
   data-project="{{ $project->defaultTranslation->name }}"
   data-questionnaire="{{ $questionnaire->currentFieldsTranslation->title }}"
   data-questionnaireId="{{ $questionnaire->id }}"
   data-medium="facebook"
   href="{{ $socialShareURL }}"
   class="social-share-button btn {{ $additionalBtnStyleClasses }}">
    {!! $btnText !!}
</a>
