<a href="#ideas" id="ideasBtn" rel="modal:open">Идеи</a></p>


<div id="ideas" class="modal">
    <div class="ideasWrapper">
        <div class="ideasTabsNav">
            {foreach $data as $type index=$index}
                <a href="#" {if $index == 0}class="active"{/if} data-tab="{$type.id}">{$type.name}</a>
            {/foreach}
        </div>
        <div class="ideasTabs">
            {foreach $data as $type index=$index}
                <div class="ideasTab {if $index == 0}active{/if}" data-tab="{$type.id}">
                    {if $type.posts | count > 0}
                        {foreach $type.posts as $post}
                            <div class="ideasPost">
                                {$post | print}
                            </div>
                        {/foreach}
                    {else}
                        <p>В разделе {$type.name} пока ничего нет</p>
                    {/if}
                </div>
            {/foreach}
        </div>

    </div>
    <a href="#" rel="modal:close">Close</a>
</div>