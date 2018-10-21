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
                                <h3>{$post.name}</h3>
                                <p>{$post.description}</p>
                                <span>{$post.status_name}</span>

                                <div class="ideas_vote">
                                    <a data-post="{$post.id}" data-action="vote_for">Согласен <span>{$post.vote_for}</span></a>
                                    <a data-post="{$post.id}" data-action="vote_aganist">Не согласен <span>{$post.vote_aganist}</span></a>
                                </div>
                            </div>
                        {/foreach}
                    {else}
                        <p>В разделе {$type.name} пока ничего нет</p>
                    {/if}
                </div>
            {/foreach}
        </div>

    </div>
</div>