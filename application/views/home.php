    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    //upload box
                        $this->load->view('upload_box');
                    ?>

                </div>
            </div>
        </div>
    </header>

    <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Recent Visualizations</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">

                <?php
                $this->load->view('latest', $latest_charts);
                ?>

            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <p>ChartChap is a free data visualization tool that enables non programmers to be able to use Google Charts in their projects and blog posts.</p>
                </div>
                <div class="col-lg-4">
                    <p>It also allows you to merge different datasets and create visualizations out of them.</p>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <a class="btn btn-lg btn-outline">
                        <i class="fa fa-code"></i> Embeddable Charts & Graphs!
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="merge">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Merge Datasets</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <?php
                        $this->load->view('merge');
                    ?>
                </div>
            </div>
        </div>
    </section>