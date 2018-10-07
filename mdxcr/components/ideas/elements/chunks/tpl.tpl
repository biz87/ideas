<div class="container">
    <p><a href="#ex1" rel="modal:open">Идеи</a></p>
</div>


<div id="ex1" class="modal">
    <div class="ideasWrapper">
        <div class="ideasTabsNav">
            {'!pdoResources' | snippet : [
            'loadModels' => 'ideas',
            'class' => 'ideasType',
            'sortby' => 'id',
            'sortdir' => 'asc'
            'tpl' => '@INLINE <a href="#" {if $idx==1}class="active"{/if}>{$name}</a>'
            ]}

        </div>

    </div>
    <a href="#" rel="modal:close">Close</a>
</div>