/**
 * CKEditor config for signature.
 */

CKEDITOR.editorConfig = function (config) {
    config.language = 'en';
    config.skin = 'bootstrapck';

    config.toolbar = [
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
        { name: 'links', items: ['Link', 'Unlink'] },
        { name: 'others', items: ['Smiley'] },
        { name: 'editing', items: ['Scayt'] },
        { name: 'tools', items: ['Maximize'] },
        { name: 'document', items: ['Source'] },
    ];

    config.removePlugins = 'contextmenu,liststyle,tabletools,forms';
    config.removeDialogTabs = 'image:advanced;image:Link;link:advanced;link:target;';
};