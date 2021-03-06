var units          =   function(
    unitsTextDomain,
    $scope,
    $http,
    unitsFields,
    unitsResource,
    $location,
    sharedValidate,
    sharedRawToOptions,
    sharedDocumentTitle,
    sharedMoment
) {

    sharedDocumentTitle.set( '<?php echo _s( 'Ajouter une unité', 'nexopos_advanced' );?>' );
    $scope.textDomain       =   unitsTextDomain;
    $scope.fields           =   unitsFields;
    $scope.item             =   {};
    $scope.validate         =   new sharedValidate();

    //Submitting Form

    $scope.submit       =   function(){
        $scope.item.author          =   <?= User::id()?>;
        $scope.item.date_creation   =   sharedMoment.now();

        if( ! $scope.validate.run( $scope.fields, $scope.item ).isValid ) {
            return $scope.validate.blurAll( $scope.fields, $scope.item );
        }

        $scope.submitDisabled       =   true;

        unitsResource.save(
            $scope.item,
            function(){
                if( $location.search().fallback ) {
                    $location.url( $location.search().fallback );
                } else {
                    $location.url( '/units?notice=done' );
                }
            },function( returned ){

                $scope.submitDisabled   =   false;

                if( returned.data.status === 'alreadyExists' ) {
                    sharedAlert.warning( '<?php echo _s( 'Le nom de cette unité est déjà en cours d\'utilisation, veuillez choisir un autre nom.', 'nexopos_advanced' );?>' );
                }

                if( returned.data.status === 'forbidden' || returned.status == 500 ) {
                    sharedAlert.warning( '<?php echo _s( 'Une erreur s\'est produite durant l\'opération.', 'nexopos_advanced' );?>' );
                }
            }
        )
    }
}

units.$inject    =   [
    'unitsTextDomain',
    '$scope',
    '$http',
    'unitsFields',
    'unitsResource',
    '$location',
    'sharedValidate',
    'sharedRawToOptions',
    'sharedDocumentTitle',
    'sharedMoment'
];
tendooApp.controller( 'units', units );
