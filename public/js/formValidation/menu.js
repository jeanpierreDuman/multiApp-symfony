$('#menu_form')
    .form({
        fields: {
            structure: {
                identifier: 'menu[structure]',
                rules: [{
                    type: 'empty',
                    prompt: 'La structure du menu ne doit pas être vide'
                }]
            },
            name: {
                identifier: 'menu[name]',
                rules: [{
                    type: 'empty',
                    prompt: 'Le nom du menu ne doit pas être vide'
                }]
            },
            route: {
                identifier: 'menu[route]',
                rules: [{
                    type: 'empty',
                    prompt: 'La route du menu ne doit pas être vide'
                }]
            }
        }
    },
);

$('#menu_society')
    .dropdown({
        clearable: true,
    })
;
