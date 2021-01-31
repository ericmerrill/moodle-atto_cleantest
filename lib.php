<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Atto test library functions.
 *
 * @package    atto_cleantest
 * @copyright  2021 Eric Merrill (merrill@oakland.edu)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Set params for this plugin.
 *
 * @param string $elementid
 * @param stdClass $options - the options for the editor, including the context.
 * @param stdClass $fpoptions - unused.
 */
function atto_cleantest_params_for_js($elementid, $options, $fpoptions) {
    $tests = [
        [
            'about' => 'Single orphan li.',
            'input' => '
<li>Something</li>',
            'expected' => '
<ul><li>Something</li></ul>'
        ], [
            'about' => 'Good html, do nothing.',
            'input' => '
<ol class="someClass">
    <li>Something</li>
</ol>',
            'expected' => '
<ol class="someClass">
    <li>Something</li>
</ol>'
        ], [
            'about' => 'Missing ol start tag.',
            'input' => '
    <li>Something 1</li>
    <li>Something 2</li>
</ol>',
            'expected' => '
    <ol><li>Something 1</li>
    <li>Something 2</li>
</ol>'
        ], [
            'about' => 'Missing ul start tag.',
            'input' => '
    <li>Something 1</li>
    <li>Something 2</li>
</ul>',
            'expected' => '
    <ul><li>Something 1</li>
    <li>Something 2</li>
</ul>'
        ], [
            'about' => 'Missing li start tag.',
            'input' => '
<ul>
    Something 1</li>
    <li>Something 2</li>
</ul>',
            'expected' => '
<ul><li>
    Something 1</li>
    <li>Something 2</li>
</ul>'
        ], [
            'about' => 'Missing li start tag list.',
            'input' => '
<ul>
    <li>Something 1</li>
    Something 3</li>
    <li>Something 2</li>
</ul>',
            'expected' => '
<ul>
    <li>Something 1</li><li>
    Something 3</li>
    <li>Something 2</li>
</ul>'
        ], [
            'about' => 'Close li with no content before it.',
            'input' => '
<ul></li>
    <li>Something 2</li>
</ul>',
            'expected' => '
<ul>
    <li>Something 2</li>
</ul>'
        ], [
            'about' => 'Extra ol closing tag.',
            'input' => '
<ol>
    <li>Something 1</li>
    <li>Something 2</li>
</ol>
</ol>',
            'expected' => '
<ol>
    <li>Something 1</li>
    <li>Something 2</li>
</ol>
'
        ], [
            'about' => 'Incorrect list close tag.',
            'input' => '
<ol>
    <li>Something 1</li>
    <li>Something 2</li>
</ul>',
            'expected' => '
<ol>
    <li>Something 1</li>
    <li>Something 2</li></ol>
'
        ], [
            'about' => 'Incorrect list close tag - empty.',
            'input' => '
<ol>
</ul>',
            'expected' => '

'
        ], [
            'about' => 'Extra ul closing tag.',
            'input' => '
<ul>
    <li>Something 1</li>
    <li>Something 2</li>
</ul>
</ul>',
            'expected' => '
<ul>
    <li>Something 1</li>
    <li>Something 2</li>
</ul>
'
        ], [
            'about' => 'Orphaned li tags, with other content.',
            'input' => '
<p>Something before</p>
<li>A</li>
<li>B</li>
<p>Something after</p>',
            'expected' => '
<p>Something before</p>
<ul><li>A</li>
<li>B</li></ul>
<p>Something after</p>'
        ], [
            'about' => 'Missing closing li.',
            'input' => '
<ul>
    <li>Something 1
</ul>
<ul>
    <li>Something 2</li>
</ul>',
            'expected' => '
<ul>
    <li>Something 1
</li></ul>
<ul>
    <li>Something 2</li>
</ul>'
        ], [
            'about' => 'Missing closing li multiple lines.',
            'input' => '
<ul>
    <li>Something 1</li>
    <li>Something 2
</ul>',
            'expected' => '
<ul>
    <li>Something 1</li>
    <li>Something 2
</li></ul>'
        ], [
            'about' => 'Missing closing li mid list',
            'input' => '
<ul>
    <li>Something 1</li>
    <li>Something 2
    <li>Something 3</li>
</ul>',
            'expected' => '
<ul>
    <li>Something 1</li>
    <li>Something 2
    </li><li>Something 3</li>
</ul>'
        ], [
            'about' => 'Missing closing li and ul.',
            'input' => '
<ul>
    <li>Something 1',
            'expected' => '

    Something 1'
        ], [
            'about' => 'Missing closing li and ul with other content.',
            'input' => '
<ul>
    <li>Something 1</li>
    <li>Something 2
<p>Something after</p>',
            'expected' => '
<ul>
    <li>Something 1</li></ul>
    Something 2
<p>Something after</p>'
        ], [
            'about' => 'Orphan list items with missing close li',
            'input' => '
<li>Something 1</li>
<li>Something 2',
            'expected' => '
Something 1
Something 2'
        ], [
            'about' => 'List with nested lis',
            'input' => '
<ul>
    <li>Something 1<li>Something 3</li></li>
    <li>Something 2</li>
</ul>',
            'expected' => '
<ul>
    <li>Something 1</li><li>Something 3</li>
    <li>Something 2</li>
</ul>'
        ], [
            'about' => 'List with nested lis on different lines',
            'input' => '
<ul>
    <li>Something 1
    <li>Something 3</li></li>
    <li>Something 2</li>
</ul>',
            'expected' => '
<ul>
    <li>Something 1
    </li><li>Something 3</li>
    <li>Something 2</li>
</ul>'
        ], [
            'about' => 'Missing closing ul with nested lists',
            'input' => '
<p>Something before</p>
<ul>
    <li>A</li>
    <ol>
        <li>1</li>
        <li>2</li>
    </ol>
    <li>B</li>
<p>Something after</p>',
            'expected' => '
<p>Something before</p>
<ul>
    <li>A</li>
    <ol>
        <li>1</li>
        <li>2</li>
    </ol>
    <li>B</li></ul>
<p>Something after</p>'
        ], [
            'about' => 'Missing closing ul and ol nested',
            'input' => '
<p>Something before</p>
<ul>
    <li>A</li>
    <ol>
        <li>1</li>
        <li>2</li>
    <li>B</li>
<p>Something after</p>',
            'expected' => '
<p>Something before</p>
<ul>
    <li>A</li></ul>
    <ol>
        <li>1</li>
        <li>2</li>
    <li>B</li></ol>
<p>Something after</p>'
        ], [
            'about' => 'Missing closing ul and ol nested, different lis',
            'input' => '
<p>Something before</p>
<ul>
    <ol>
        <li>1</li>
        <li>2</li>
<p>Something after</p>',
            'expected' => '
<p>Something before</p>

    <ol>
        <li>1</li>
        <li>2</li></ol>
<p>Something after</p>'
        ], [
            'about' => 'Content with tags in content',
            'input' => '
<div class="li ul ol">
    &lt;li&gt;
    &lt;ul&gt;
    &lt;ol&gt;
</div>',
            'expected' => '
<div class="li ul ol">
    &lt;li&gt;
    &lt;ul&gt;
    &lt;ol&gt;
</div>'
        ], [
            'about' => 'Orphaned LI between other lists',
            'input' => '
<ol>
    <li>Something 1</li>
    <li>Something 2</li>
</ol>

<li>Something 3</li>
<li>Something 4</li>

<ul>
    <li>Something 5</li>
    <li>Something 6</li>
</ul>',
            'expected' => '
<ol>
    <li>Something 1</li>
    <li>Something 2</li>
</ol>

<ul><li>Something 3</li>
<li>Something 4</li></ul>

<ul>
    <li>Something 5</li>
    <li>Something 6</li>
</ul>'
        ], [
            'about' => 'Random more complex good HTML',
            'input' => '
<h3 style="text-align: center;">Introduction</h3>
<p style="text-align: center;"><span style="font-size: 14px; line-height: 20px; font-weight: normal;">Online</span></p>


<h4 style="text-align: center;">Instructor</h4>
<p style="text-align: center;">
    <span style="font-weight: normal; font-size: 14px;">
        Someone (<a href="mailto:admin@example.com">admin@example.com</a>)<br></span></p>',
            'expected' => '
<h3 style="text-align: center;">Introduction</h3>
<p style="text-align: center;"><span style="font-size: 14px; line-height: 20px; font-weight: normal;">Online</span></p>


<h4 style="text-align: center;">Instructor</h4>
<p style="text-align: center;">
    <span style="font-weight: normal; font-size: 14px;">
        Someone (<a href="mailto:admin@example.com">admin@example.com</a>)<br></span></p>'
        ], [
            'about' => 'Another random, more complext, good html',
            'input' => '
<h4>The Requirements</h4>
<p>These are the things I will be looking for while grading (aka <span>The Requirements</span>):</p>
<ul>
    <li>Player:</li>
    <ul>
        <li>Player walks around with the W, A, S, D controls. (4 pts)</li>
        <li>The correct direction animation should play when a direction key is pressed.&nbsp;(4 pts)</li>
        <li>When the direction key is released, the player should stop moving and stop animating.&nbsp;(2 pts)</li>
        <li>The player cannot pass through walls.&nbsp;(2 pts)</li>
    </ul>
    <li>Lives<br></li>
    <ul>
        <li>The current number of lives is displayed in the top left corner.&nbsp;(2 pts)</li>
        <li>Player starts with 3 lives.&nbsp;(2 pts)</li>
        <li>If the player gets to 0 lives, the death animation should play, and the lost message is displayed when that completes.&nbsp;(4 pts)</li>
    </ul>
    <li>Potions<br></li>
    <ul>
        <li>There must be at least 2 potions in the game.&nbsp;(1 pts)</li>
        <li>Colliding with a potion adds 1 life.&nbsp;(2 pts)</li>
        <li>The potion is removed when it is "used".&nbsp;(2 pts)</li>
    </ul>
    <li>Bombs</li>
    <ul>
        <li>There must be at least 3 bombs in the game.&nbsp;(1 pts)</li>
        <ul>
            <li>There should be only 1 bomb object, but at least 3 instances of that bomb.</li>
        </ul>
        <li>When the player runs into a bomb, one life is deducted.&nbsp;(2 pts)</li>
        <li>When the player runs into a bomb, the explosion animation is played once, and the bomb is removed at the end of the animation.&nbsp;(4 pts)</li>
        <li>When the bomb animation plays, should play immediately through (once). It shouldn\'t hang on the first (or any) frame while the player is still in contact with it.&nbsp;(2 pts)</li>
    </ul>
    <li>Exit</li>
    <ul>
        <li>When the user gets to the exit door, the won message should be displayed.&nbsp;(3 pts)</li>
    </ul>
    <li>Misc</li>
    <ul>
        <li>There must be a perimeter of walls all the way around the room, preventing the player from leaving the game area.&nbsp;(2 pts)<br></li>
        <li>There must be at least 1 wall segment inside the room, at least 5 blocks long, in the room.&nbsp;(2 pts)</li>
        <li>The sand background must be used in a tiled background layer.&nbsp;(2 pts)</li>
        <li>From both the Win or Lose screen, clicking lets the player play again.&nbsp;(3 pts)</li>
        <li>In the resources (right sidebar), go to Options &gt; Main and enter your name next to Author.&nbsp;(2 pts)</li>
        <li>Sprites, Objects, and Rooms should have descriptive names and prefixes.&nbsp;(2 pts)</li>
    </ul>
    <li>Made a Submission with required YYZ file. (25pts)</li>
    <li>Instructor\'s discretion. (25pts)</li>
    <ul>
        <li>General feel of how much effort was put in, sought out help, etc.</li>
    </ul>
</ul>
<p></p>
<p>You can add interesting or fun things like like sound effects, or different types of enemies for <strong>extra-credit</strong>.<br></p>
<p><br></p>
<p>The example I have provided has a bit more polish than the base requirements. So some things to <strong>keep in mind</strong>:</p>
<p></p>
<ul>
    <li>Your layout does not need to match mine exactly (or at all), as long as you meet the requirements spelled out above.</li>
    <li>You may notice differences between your game and mine with how pressing multiple directions keys at once or hitting walls causes the player to behave and animate. As long as you meet the requirements spelled out above, you are ok.</li>
</ul>
<p></p>
<h4 id="tipsandhints">Tips and Hints</h4>
<p></p>
<ul>
    <li>Won\'t worry about the requirements all at once. You want to work through each feature like getting the player to move, then animate. Then worry about walls, then bombs, etc.</li>
    <li><a href="https://mymoodle.site/mod/assign/view.php?id=4734367" target="_blank">Exercise 5</a> and&nbsp;<a href="https://mymoodle.site/mod/assign/view.php?id=4734375" target="_blank">Exercise 6</a> are largely based around this project. I
        recommend you do them as early in the process of working on this as you can.</li>
    <ul>
        <li>Exercise 6 uses an obj_bomb1 and obj_bomb2, but that is only to show two different behaviors. For this project, you will only have one bomb object (with many instances), and it will behave like obj_bomb2 from the exercise.</li>
        <li>The above exercises have almost verbatim walkthroughs of things you need to in in this project.</li>
    </ul>
    <li>I used 3 rooms in my design - the game room, a winning room with the spt_exit image on an object, and a loosing room with the spt_died image on an object.</li>
    <ul>
        <li>You will want to use the <strong>Go To Room</strong><img src="https://mymoodle.site/draftfile.php/18814/user/draft/99801609/gotoroom.png" alt="Icon: Down arrow in box" width="32" height="32" class="img-responsive atto_image_button_middle">action.</li>
    </ul>
    <li>The basic requirements can be done using only drag and drop, but you may use code if you would like (Like you do in Exercise 5).</li>
    <li>You should only only have one bomb <strong>object</strong> in your project, you don\'t need one for each bomb instance.</li>
    <li>You should only have one explorer object in your game (excluding one when he dies) - you should <strong>not</strong> use instance switching for the players different walking directions.</li>
    <li>Remember that you can have an action effect either the current (self) object, or the "other" object in a collision.</li>
    <li>You will need to use something like the If Lives action to check when the player runs out of lives, and then kill the appropriately.</li>
    <ul>
        <li>Remember that you must attach things you want to happen when an If is true to the <strong>right</strong> side of it. Not to the bottom of it.</li>
    </ul>
</ul>',
            'expected' => '
<h4>The Requirements</h4>
<p>These are the things I will be looking for while grading (aka <span>The Requirements</span>):</p>
<ul>
    <li>Player:</li>
    <ul>
        <li>Player walks around with the W, A, S, D controls. (4 pts)</li>
        <li>The correct direction animation should play when a direction key is pressed.&nbsp;(4 pts)</li>
        <li>When the direction key is released, the player should stop moving and stop animating.&nbsp;(2 pts)</li>
        <li>The player cannot pass through walls.&nbsp;(2 pts)</li>
    </ul>
    <li>Lives<br></li>
    <ul>
        <li>The current number of lives is displayed in the top left corner.&nbsp;(2 pts)</li>
        <li>Player starts with 3 lives.&nbsp;(2 pts)</li>
        <li>If the player gets to 0 lives, the death animation should play, and the lost message is displayed when that completes.&nbsp;(4 pts)</li>
    </ul>
    <li>Potions<br></li>
    <ul>
        <li>There must be at least 2 potions in the game.&nbsp;(1 pts)</li>
        <li>Colliding with a potion adds 1 life.&nbsp;(2 pts)</li>
        <li>The potion is removed when it is "used".&nbsp;(2 pts)</li>
    </ul>
    <li>Bombs</li>
    <ul>
        <li>There must be at least 3 bombs in the game.&nbsp;(1 pts)</li>
        <ul>
            <li>There should be only 1 bomb object, but at least 3 instances of that bomb.</li>
        </ul>
        <li>When the player runs into a bomb, one life is deducted.&nbsp;(2 pts)</li>
        <li>When the player runs into a bomb, the explosion animation is played once, and the bomb is removed at the end of the animation.&nbsp;(4 pts)</li>
        <li>When the bomb animation plays, should play immediately through (once). It shouldn\'t hang on the first (or any) frame while the player is still in contact with it.&nbsp;(2 pts)</li>
    </ul>
    <li>Exit</li>
    <ul>
        <li>When the user gets to the exit door, the won message should be displayed.&nbsp;(3 pts)</li>
    </ul>
    <li>Misc</li>
    <ul>
        <li>There must be a perimeter of walls all the way around the room, preventing the player from leaving the game area.&nbsp;(2 pts)<br></li>
        <li>There must be at least 1 wall segment inside the room, at least 5 blocks long, in the room.&nbsp;(2 pts)</li>
        <li>The sand background must be used in a tiled background layer.&nbsp;(2 pts)</li>
        <li>From both the Win or Lose screen, clicking lets the player play again.&nbsp;(3 pts)</li>
        <li>In the resources (right sidebar), go to Options &gt; Main and enter your name next to Author.&nbsp;(2 pts)</li>
        <li>Sprites, Objects, and Rooms should have descriptive names and prefixes.&nbsp;(2 pts)</li>
    </ul>
    <li>Made a Submission with required YYZ file. (25pts)</li>
    <li>Instructor\'s discretion. (25pts)</li>
    <ul>
        <li>General feel of how much effort was put in, sought out help, etc.</li>
    </ul>
</ul>
<p></p>
<p>You can add interesting or fun things like like sound effects, or different types of enemies for <strong>extra-credit</strong>.<br></p>
<p><br></p>
<p>The example I have provided has a bit more polish than the base requirements. So some things to <strong>keep in mind</strong>:</p>
<p></p>
<ul>
    <li>Your layout does not need to match mine exactly (or at all), as long as you meet the requirements spelled out above.</li>
    <li>You may notice differences between your game and mine with how pressing multiple directions keys at once or hitting walls causes the player to behave and animate. As long as you meet the requirements spelled out above, you are ok.</li>
</ul>
<p></p>
<h4 id="tipsandhints">Tips and Hints</h4>
<p></p>
<ul>
    <li>Won\'t worry about the requirements all at once. You want to work through each feature like getting the player to move, then animate. Then worry about walls, then bombs, etc.</li>
    <li><a href="https://mymoodle.site/mod/assign/view.php?id=4734367" target="_blank">Exercise 5</a> and&nbsp;<a href="https://mymoodle.site/mod/assign/view.php?id=4734375" target="_blank">Exercise 6</a> are largely based around this project. I
        recommend you do them as early in the process of working on this as you can.</li>
    <ul>
        <li>Exercise 6 uses an obj_bomb1 and obj_bomb2, but that is only to show two different behaviors. For this project, you will only have one bomb object (with many instances), and it will behave like obj_bomb2 from the exercise.</li>
        <li>The above exercises have almost verbatim walkthroughs of things you need to in in this project.</li>
    </ul>
    <li>I used 3 rooms in my design - the game room, a winning room with the spt_exit image on an object, and a loosing room with the spt_died image on an object.</li>
    <ul>
        <li>You will want to use the <strong>Go To Room</strong><img src="https://mymoodle.site/draftfile.php/18814/user/draft/99801609/gotoroom.png" alt="Icon: Down arrow in box" width="32" height="32" class="img-responsive atto_image_button_middle">action.</li>
    </ul>
    <li>The basic requirements can be done using only drag and drop, but you may use code if you would like (Like you do in Exercise 5).</li>
    <li>You should only only have one bomb <strong>object</strong> in your project, you don\'t need one for each bomb instance.</li>
    <li>You should only have one explorer object in your game (excluding one when he dies) - you should <strong>not</strong> use instance switching for the players different walking directions.</li>
    <li>Remember that you can have an action effect either the current (self) object, or the "other" object in a collision.</li>
    <li>You will need to use something like the If Lives action to check when the player runs out of lives, and then kill the appropriately.</li>
    <ul>
        <li>Remember that you must attach things you want to happen when an If is true to the <strong>right</strong> side of it. Not to the bottom of it.</li>
    </ul>
</ul>'
        ], [
            'about' => 'Random MS Word Paste.',
            'input' => '
<p align="center"><a name="OLE_LINK5"><span><span><span><span>My
Random Page</span></span></span></span></a></p>

<p><span><span><span><span><span>&nbsp;</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>·<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->My item 1</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>·<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->My item 2</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>·<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->My item 3</span></span></span></span></span></p>

<p><span><span><span><span><span>&nbsp;</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>1.<span>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]--><b>Number</b>
1</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>2.<span>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]-->Number
2</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>a.<span>&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->Number 2.1</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>b.<span>&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->Number 2.2</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>3.<span>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]-->Number
3</span></span></span></span></span></p>',
            'expected' => '
<p align="center"><a name="OLE_LINK5"><span><span><span><span>My
Random Page</span></span></span></span></a></p>

<p><span><span><span><span><span>&nbsp;</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>·<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->My item 1</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>·<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->My item 2</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>·<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->My item 3</span></span></span></span></span></p>

<p><span><span><span><span><span>&nbsp;</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>1.<span>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]--><b>Number</b>
1</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>2.<span>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]-->Number
2</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>a.<span>&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->Number 2.1</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>b.<span>&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><!--[endif]-->Number 2.2</span></span></span></span></span></p>

<p><span><span><span><span><span><!--[if !supportLists]--><span><span>3.<span>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]-->Number
3</span></span></span></span></span></p>'
        ]
    ];

    // Strip of starting new lines. Made this a bit easier for string formatting.
    $tests = array_map(function($test) {
            return ['input' => substr($test['input'], 1),
                    'expected' => substr($test['expected'], 1),
                    'about' => $test['about']];
    }, $tests);

    return ['tests' => $tests];

}

/**
 * Initialise the js strings required for this module.
 */
function atto_cleantest_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(array('pluginname'), 'atto_cleantest');
}

