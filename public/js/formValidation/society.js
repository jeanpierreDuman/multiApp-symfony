$('#society_form')
    .form({
        fields: {
            name: {
                identifier: 'society[name]',
                rules: [{
                    type: 'empty',
                    prompt: 'Le nom de la société ne doit pas être vide'
                }]
            }
        }
    });
