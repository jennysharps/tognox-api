jQuery(document).ready( function(jQuery) {
    downloadsPostType.init();
});


var downloadsPostType = {
    downloadTypeSelect: null,
    chosenDownloadType: null,
    downloadFields: null,
    domFieldRefs: {},
    fieldsByDownloadType: {
        'gist': ['acf-gist-id'],
        'github': ['acf-github-url'],
        'video': ['acf-video-id'],
        'file': ['acf-related-file', 'acf-button-text']
    },
    init: function() {
        this.downloadTypeSelect = jQuery('#acf-resource_type');

        if(this.downloadTypeSelect.length) {
            var chosenDownloadType = this.downloadTypeSelect.find('select :selected').val() || null;

            this.downloadFields = jQuery('#acf_acf_resource-options .field');

            this.setFieldRefs();
            this.attachEvents();
            this.showCurrentFields(chosenDownloadType);
        }
    },
    setFieldRefs: function(current) {
        var self = this;

        self.downloadFields.each( function() {
            var key = jQuery(this).attr('id');
            self.domFieldRefs[key] = jQuery(this);
        });
    },
    attachEvents: function() {
        var self = this;
        self.downloadTypeSelect.change( function() {
            var chosenDownloadType = jQuery(this).find('select :selected').val();

            self.showCurrentFields(chosenDownloadType);

        });
    },
    showCurrentFields: function(chosenDownloadType) {
        var self = this;

        self.downloadFields.removeClass('current');

        var fieldsToShow = self.fieldsByDownloadType[chosenDownloadType];

        jQuery(fieldsToShow).each( function(index, value) {
            self.domFieldRefs[value].addClass('current');
        });
    }
}