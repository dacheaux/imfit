/*!
 * FileInput Serbian Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 * @author Milos Stojanovic <stojanovic.loshmi@gmail.com>
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function ($) {
    "use strict";

    $.fn.fileinputLocales['sr'] = {
        fileSingle: 'fajl',
        filePlural: 'fajlovi',
        browseLabel: 'Izaberi &hellip;',
        removeLabel: 'Ukloni',
        removeTitle: 'Ukloni označene fajlove',
        cancelLabel: 'Odustani',
        cancelTitle: 'Prekini trenutno otpremanje',
        uploadLabel: 'Otpremi',
        uploadTitle: 'Otpremi označene fajlove',
        msgSizeTooLarge: 'Fajl "{name}" (<b>{size} KB</b>) prekoračuje maksimalnu dozvoljenu veličinu fajla od <b>{maxSize} KB</b>. Molimo pokušajte ponovo!',
        msgFilesTooLess: 'Morate odabrati najmanje <b>{n}</b> {files} za otpremanje. Molimo pokušajte ponovo!',
        msgFilesTooMany: 'Broj datoteka označenih za otpremanje <b>({n})</b> prekoračuje maksimalni dozvoljeni limit od <b>{m}</b>. Molimo pokušajte ponovo!',
        msgFileNotFound: 'Fajl "{name}" nije pronađena!',
        msgFileSecured: 'Fajl "{name}" nije moguće pročitati zbog bezbednosnih ograničenja.',
        msgFileNotReadable: 'Fajl "{name}" nije moguće pročitati.',
        msgFilePreviewAborted: 'Generisanje prikaza nije moguće za "{name}".',
        msgFilePreviewError: 'Došlo je do greške prilikom čitanja fajla "{name}".',
        msgInvalidFileType: 'Fajl "{name}" je pogrešnog formata. Dozvoljeni formati su "{types}".',
        msgInvalidFileExtension: 'Ekstenzija fajla "{name}" nije dozvoljena. Dozvoljene ekstenzije su "{extensions}".',
        msgValidationError: 'Greška prilikom otpremanja fajla',
        msgLoading: 'Učitavanje fajla {index} od {files} &hellip;',
        msgProgress: 'Učitavanje fajla {index} od {files} - {name} - {percent}% završeno.',
        msgSelected: '{n} {files} je označeno',
        msgFoldersNotAllowed: 'Moguće je prevlačiti samo fajlove! Preskočeno je {n} fascikla.',
        dropZoneTitle: 'Prevucite fajla ovde &hellip;'
    };
})(window.jQuery);
