var taxesMain          =   function( taxesTextDomain, $scope, $http, taxesResource, $location, validate, table, taxTable, paginationFactory,  sharedTableActions, sharedAlert, sharedEntryActions) {

    $scope.textDomain       =   taxesTextDomain;
    $scope.validate         =   validate;
    $scope.table            =   table;
    $scope.table.columns    =   taxTable.columns;
    $scope.table.actions    =   sharedTableActions;

        /** Adjust Entry actions **/
    _.each( sharedEntryActions, function( value, key ) {
        if( value.namespace == 'edit' ) {
            sharedEntryActions[ key ].path      =    '/taxes/edit/';
        }
    });

    $scope.table.entryActions   =   sharedEntryActions;
    $scope.table.actions        =   sharedTableActions


    /**
     *  Table Get
     *  @param object query object
     *  @return void
    **/

    $scope.table.get        =   function( params ){
        taxesResource.get( params,function( data ) {
            $scope.table.entries        =   data.entries;
            $scope.table.pages          =   Math.ceil( data.num_rows / $scope.table.limit );
        });
    }

    /**
     *  Table Delete
     *  @param object query
     *  @return void
    **/

    $scope.table.delete     =   function( params ){
        taxesResource.delete( params, function( data ) {
            $scope.table.get();
        },function(){
            sharedAlert.warning( '<?php echo _s(
                'Une erreur s\'est produite durant l\'operation',
                'nexopos_advanced'
            );?>' );
        });
    }

    // Get Results
    $scope.table.limit      =   10;
    $scope.table.order_type =   'asc';
    $scope.table.getPage(0);
}

taxesMain.$inject    =   [ 'taxesTextDomain', '$scope', '$http', 'taxesResource', '$location', 'validate', 'table', 'taxTable', 'paginationFactory' ,'sharedTableActions', 'sharedAlert', 'sharedEntryActions'];

tendooApp.controller( 'taxesMain', taxesMain );
