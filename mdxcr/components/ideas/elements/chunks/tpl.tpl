{foreach $tabs as $tab}
    <h3>Вкладка {$tab.tab_name}</h3>
    {foreach $tab.posts as $post}
        {$post | print}
    {/foreach}
{/foreach}