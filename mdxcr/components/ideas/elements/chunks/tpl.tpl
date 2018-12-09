<a href="#ideas" id="ideasBtn" rel="modal:open">Идеи</a></p>


<div id="ideas" class="modal">
    <div class="ideasWrapper">
        <div class="ideasTabsNav">
            {foreach $data as $type index=$index}
                <a href="#" {if $index == 0}class="active"{/if} data-tab="{$type.id}">{$type.name}</a>
            {/foreach}
        </div>
        <form>
            <select class="selectIdeasTabs" name="selectIdeasTabs">
                {foreach $data as $type index=$index}
                    <option value="{$type.id}">{$type.name}</option>
                {/foreach}
            </select>
        </form>
        <div class="ideasTabs">
            {foreach $data as $type index=$index}
                <div class="ideasTab {if $index == 0}active{/if}" data-tab="{$type.id}">
                    <form method="POST" class="new_idea_form">
                        <p>Добавьте вашу идею в раздел  <strong>{$type.name}</strong></p>
                        <label>
                            <input type="text" name="idea_title" placeholder="Ваша идея">
                            <small>Заголовок должен быть кратким. Остальное пишите в описании</small>
                        </label>
                        <input type="hidden" name="idea_type" value="{$type.id}">
                        <div hidden>
                            <label>
                                <textarea name="idea_description" placeholder="Подробное описание идеи"></textarea>
                                <small>Подробное описание идеи (опционально)</small>
                            </label>
                            <input type="hidden" name="action" value="new_idea">
                            <button type="submit" class="new_idea_submit">Добавить идею</button>
                        </div>
                    </form>
                    {if $type.posts | count > 0}
                        {foreach $type.posts as $post}
                            <div class="ideasPost">
                                <div class="ideasPostStatus">
                                    <span class="ideasPostStatusLabel">Статус:</span>
                                    <span class="ideasPostStatusValue">{$post.status_name}</span>
                                </div>

                                <div class="ideasPostContent">
                                    <h3>{$post.name}</h3>
                                    <p>{$post.description}</p>
                                    <div class="ideas_vote">
                                        <a data-post="{$post.id}" data-action="vote_for">Согласен <span>{$post.vote_for}</span></a>
                                        <a data-post="{$post.id}" data-action="vote_aganist">Не согласен <span>{$post.vote_aganist}</span></a>
                                    </div>
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