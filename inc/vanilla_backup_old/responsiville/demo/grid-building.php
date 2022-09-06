<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Grid building</h1>

        <p>
            The building components of a grid in Responsiville are: containers, rows, panels,and columns. Columns have a lot of variations to them to satisfy all kinds of possible layouts. But the main idea is that your content should lie inside columns. Columns are your blocks of content. Let&apos; start with an example and note how the grid automatically takes care of vertically aligning the edges of all columns inside it:
        </p>

        <div class = "grid-showcase">
            <div class = "row" data-info = ".row">
                <div class = "column-100" data-info = ".column-100"></div>
            </div>
            <div class = "row" data-info = ".row">
                <div class = "column-50" data-info = ".column-50"></div>
                <div class = "column-50" data-info = ".column-50"></div>
            </div>
            <div class = "row" data-info = ".row">
                <div class = "column-25" data-info = ".column-25"></div>
                <div class = "column-25" data-info = ".column-25"></div>
                <div class = "column-25" data-info = ".column-25"></div>
                <div class = "column-25" data-info = ".column-25"></div>
            </div>
            <div class = "row" data-info = ".row">
                <div class = "column-25" data-info = ".column-25"></div>
                <div class = "column-50" data-info = ".column-50"></div>
                <div class = "column-25" data-info = ".column-25"></div>
            </div>
        </div>

        <p>
            And the code for this is:
        </p>

        <pre><code class = "language-markup"><!--
            <div class="container">
                <div class="row">
                    <div class="column-100"></div>
                </div>
                <div class="row">
                    <div class="column-50"></div>
                    <div class="column-50"></div>
                </div>
                <div class="row">
                    <div class="column-25"></div>
                    <div class="column-25"></div>
                    <div class="column-25"></div>
                    <div class="column-25"></div>
                </div>
                <div class="row">
                    <div class="column-25"></div>
                    <div class="column-50"></div>
                    <div class="column-25"></div>
                </div>
            </div>
        --></code></pre>



        <h2>Containers, rows, panels and columns</h2>

        <p>
            In the example above all you see actually <strong>rows</strong> and <strong>columns</strong>. What about containers and panels? Well they are optional, but they help a lot when you need them. The general architecture hierarchy of the grid goes like this:
        </p>

        <dl>
            <dt>container (optional)</dt>
            <dd>
                A general structural element that contains other elements. Usually used for the general layout. Apart from logically separating the layout, it poses a clearfix on its contents. It is optional in the sense that you do not have to use the framework&apos;s containers, you may use your own, as long as you know what you are doing.
            </dd>
            <dt>row</dt>
            <dd>
                A very important structural element of the grid. It defines a row of content. Logically, a row of content is a set of columns (that may visually take up more than one rows of content - after all screen widths vary a lot). Structurally, it makes sure that the gutters of the columns do not add up when nesting them inside one another and the grid remains vertically aligned. 
            </dd>
            <dt>panel (optional)</dt>
            <dd>
                By convention does nothing more than apply a maximum width to the contents -usually- of a row. With a panel you have a uniform way to restrict your contents to specific widths for each breakpoint.
            </dd>
            <dt>column(s)</dt>
            <dd>
                They are the building blocks of the grid. They are put next to each other, inside rows, like the cells of a table. They contain gutters for your design to allow for breathing space, so be careful when nesting them. You are not obliged to put them inside rows, but doing so helps maintain the design&apos;s overall vertical alignment.
            </dd>
        </dl>

        <p>
            This hierarchy reads something like this: you usually divide your layout in general containers, inside which you have rows of content, which you put in columns, but sometimes you need to constrain your content to a certain maximum width, so then you first put it (ie the columns which contain the content) inside panels and them inside rows.
        </p>

        <pre><code class = "language-markup"><!--
            .container >
                .row > 
                    .panel >
                        .column(s)
        --></code></pre>

        <p>
            So, in reality only columns are absolutely necessary for one to define a grid. Panels can be useful to constrain the maximum width of the content. Rows are necessary, too, if the grid needs to vertically align its contents - and this is a very common case in responsive web design. Containers are a nice-to-have addition for logical and clearing purposes.
        </p>



        <h2>A classic example</h2>

        <p>
            Let&apos;s create the classic layout that consists of a header, a footer, a sidebar and the contents.
        </p>

        <div class = "grid-showcase">
            <div class = "row" data-info = ".row">
                <div class = "column-100" data-info = ".column-100">
                    <div class = "grid-contents clear">Header</div>
                </div>
            </div>
            <div class = "row" data-info = ".row">
                <div class = "column-25" data-info = ".column-25"></div>
                <div class = "column-75" data-info = ".column-75"></div>
            </div>
            <div class = "row" data-info = ".row">
                <div class = "column-100" data-info = ".column-100"></div>
            </div>
        </div>

        <p>
            Note that we did not use a container or a panel here.
        </p>



    </article>

<!--
    center, right, left
    container, panel, row, column
    inline, block
    container, clear
    hidden
 -->


<?php include( 'footer.php' ); ?>