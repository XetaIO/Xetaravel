<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.',
            'slug' => 'lorem-ipsum-dolor-sit-amet-consectetuer-adipiscing-elit',
            'content' => '<p><strong>Lorem ipsum</strong> dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>

<blockquote>
<p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
</blockquote>

<p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat :&nbsp;</p>

<ul>
	<li>vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto</li>
	<li>odio dignissim qui blandit praesent luptatum zzril</li>
	<li>delenit augue duis dolore te feugait nulla facilisi</li>
</ul>

<p>&nbsp;</p>

<p>Odio dignissim qui <code>&lt;?= $this-&gt;Html-&gt;link(&#39;test&#39;, [&#39;key&#39; =&gt; true]) ?&gt;</code> te feugait nulla facilisi.</p>

<p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.&nbsp;</p>

<p>&nbsp;</p>

<pre data-pbcklang="php" data-pbcktabsize="4">
<code class="php hljs">&lt;?php
namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class Logs implements EventListenerInterface
{
    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            &#39;Log.User&#39; =&gt; &#39;userLog&#39;
        ];
    }

    /**
     * An user has doing an important action, we log it.
     *
     * @param Event $event The event that was fired.
     *
     * @return bool
     */
    public function userLog(Event $event)
    {
        $this-&gt;UsersLogs = TableRegistry::get(&#39;UsersLogs&#39;);

        $data = [
            &#39;user_id&#39; =&gt; $event-&gt;getData(&#39;user_id&#39;),
            &#39;username&#39; =&gt; $event-&gt;getData(&#39;username&#39;),
            &#39;user_ip&#39; =&gt; $event-&gt;getData(&#39;user_ip&#39;),
            &#39;user_agent&#39; =&gt; $event-&gt;getData(&#39;user_agent&#39;),
            &#39;action&#39; =&gt; $event-&gt;getData(&#39;action&#39;)
        ];

        $entity = $this-&gt;UsersLogs-&gt;newEntity($data);
        $this-&gt;UsersLogs-&gt;save($entity);

        return true;
    }
}</code></pre>

<p>&nbsp;</p>',
            'comment_count' => 1,
            'is_display' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}