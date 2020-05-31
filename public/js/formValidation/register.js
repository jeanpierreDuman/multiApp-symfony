$('#register')
    .form({
        fields: {
            name: {
                identifier: 'registration_form[name]',
                rules: [{
                    type: 'empty',
                    prompt: 'Le nom complet ne doit pas être vide'
                }]
            },
            society: {
                identifier: 'registration_form[society]',
                rules: [{
                    type: 'empty',
                    prompt: 'Vous devez sélectionner une société'
                }]
            },
            email: {
                identifier: 'registration_form[email]',
                rules: [{
                    type: 'empty',
                    prompt: "L'email ne doit pas être vide"
                }]
            },
            plainPassword: {
                identifier: 'registration_form[plainPassword]',
                rules: [{
                    type: 'empty',
                    prompt: "Le mot de passe ne doit pas être vide"
                }, {
                    type: 'minLength[6]',
                    prompt: 'Le mot de passe doit contenir au moins 6 caractères'
                }]
            }
        }
    });

$('.dropdown')
    .dropdown({
        clearable: true,
    })
;
