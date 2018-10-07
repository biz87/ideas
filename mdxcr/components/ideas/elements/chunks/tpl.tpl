<div id="ex1" class="modal">
    {foreach $tabs as $tab}
        <h2>Вкладка {$tab.tab_name}</h2>
        {foreach $tab.posts as $post}
            <div class="ideasPost">
                <h3>{$post['name']}<h3>
                        {if $post.description?}{/if}
            </div>
        {/foreach}
    {/foreach}


    <a href="#" rel="modal:close">Close</a>
</div>