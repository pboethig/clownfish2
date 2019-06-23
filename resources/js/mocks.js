var definition = {

    database:
        {
            name: 'database',
            table: 'tabellenname',
        },
    primary_keys:
        {
            source: 'Spalte 1',
            target: 'Spalte 2',
        },
    existing_fields:
        [
            {
                firstname:
                    {
                        type: 'simple',
                        source: 'Spalte 1',
                        target: 'Spalte 2',
                    },
                name:
                    {
                        type: 'condition',
                        when:
                            [
                                {
                                    source: 'Spalte A',
                                    operator: '>=',
                                    target: null,
                                    freetext: 10,
                                },
                                {
                                    source: 'Spalte B',
                                    operator: '>=',
                                    target: null,
                                    freetext: 20,
                                }
                            ],
                        then:
                            {
                                target: 'Spalte B',
                                source: null,
                                freetext: 20,

                            },
                        else:
                            {
                                source: 'Spalte 1',
                                target: 'Spalte 2',

                            },
                        modifier:
                            [
                                {
                                    operation: '*',
                                    column: null,
                                    freetext: '10%',

                                },
                                {
                                    operation: '/',
                                    column: null,
                                    freetext: 3,

                                }
                            ]

                    }
            }
        ]
};