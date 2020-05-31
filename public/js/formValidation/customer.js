$('#customer')
    .form({
        fields: {
            name: {
                identifier: 'customer[name]',
                rules: [{
                    type: 'empty',
                    prompt: 'Le nom ne doit pas être vide'
                }]
            },
            street: {
                identifier: 'customer[street]',
                rules: [{
                    type: 'empty',
                    prompt: 'La rue ne doit pas être vide'
                }]
            },
            zipCode: {
                identifier: 'customer[zipCode]',
                rules: [{
                    type: 'empty',
                    prompt: "Le code postal ne doit pas être vide"
                }]
            },
            city: {
                identifier: 'customer[city]',
                rules: [{
                    type: 'empty',
                    prompt: "La ville ne doit pas être vide"
                }]
            },
        }
    });

$('.dropdown')
    .dropdown({
        clearable: true,
    })
;
