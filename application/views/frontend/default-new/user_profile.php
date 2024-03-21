<?php $user_details = $this->user_model->get_all_user($this->session->userdata('user_id'))->row_array(); ?>
<?php $social_links = json_decode($user_details['social_links'], true); ?>


<?php include "breadcrumb.php"; ?>

<!--------  Wish List body section start------>
<section class="wish-list-body message">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <?php include "profile_menus.php"; ?>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="profile">
                    <div class="profile-bg">
                        <!-- <img loading="lazy" src="<?php echo base_url('assets/frontend/default-new/img/profile-bg-2.jpg') ?>"> -->
                    </div>
                    <div class="profile-ful-body common-card">
                        <div class="profile-parrent mt-5">
                            <div class="profile-child">
                                <a href="#"><img loading="lazy" src="<?php echo $this->user_model->get_user_image_url($user_details['id']); ?>"></a>
                                <div class="child-text">
                                    <a href="#">
                                        <h5><?php echo get_phrase('Profile Photo') ?></h5>
                                    </a>
                                    <p><?php echo get_phrase('Update your profile photo and personal details'); ?></p>
                                </div>
                            </div>

                            <div class="profile-child-btn">
                                <form action="<?php echo site_url('home/update_profile/update_photo/true') ?>" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                                    <input type="file" id="profile-photo-input" name="user_image" onchange="
                                        $('.photo-upload-btn').toggleClass('d-hidden');
                                        $('[for=profile-photo-input]').toggleClass('d-hidden');
                                    " class="d-none">
                                    <label for="profile-photo-input" class="btn btn-light float-end" type="button" style="background-color: var(--bs-gray-200);"><i class="fas fa-upload"></i> <?php echo get_phrase('Upload photo') ?></label>
                                    <div class="photo-upload-btn d-hidden">
                                        <button type="submit" class="purchase-btn ms-1 float-end"><?php echo get_phrase('Save') ?></button>
                                        <button type="reset" onclick="
                                            $('.photo-upload-btn').toggleClass('d-hidden');
                                            $('[for=profile-photo-input]').toggleClass('d-hidden');
                                        " class="purchase-btn float-end"><?php echo get_phrase('Cancel') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="profile-input-section">
                            <form class="" action="<?php echo site_url('home/update_profile/update_basics'); ?>" method="post">
                                <div class="row">
                                    <div class="col-12 border-bottom mb-3 pb-3">
                                        <h4 class="text-black"><?php echo site_phrase('Profile Info'); ?></h4>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="text-dark fw-600" for="FristName"><?php echo site_phrase('first_name'); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control bg-white-2 text-14px" name="first_name" id="FristName" placeholder="<?php echo site_phrase('first_name'); ?>" value="<?php echo $user_details['first_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-dark fw-600" for="FristName"><?php echo site_phrase('last_name'); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control bg-white-2 text-14px" name="last_name" placeholder="<?php echo site_phrase('last_name'); ?>" value="<?php echo $user_details['last_name']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="text-dark fw-600" for="company_name"><?php echo site_phrase('company_name'); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control bg-white-2 text-14px" id="company_name" placeholder="<?php echo site_phrase('company_name'); ?>" name="company_name" value="<?php echo $user_details['company_name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="text-dark fw-600" for="fiscal_number"><?php echo get_phrase('fiscal_number'); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control bg-white-2 text-14px" id="fiscal_number" name="fiscal_number" value="<?php echo $user_details['fiscal_number']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label class="text-dark fw-600" for="location"><?php echo get_phrase('location'); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control bg-white-2 text-14px" id="location" name="location" value="<?php echo $user_details['location']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label class="text-dark fw-600" for="economic_code"><?php echo get_phrase('economic_code'); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <select class="form-select form-control bg-white-2 text-14px" id="economic_code" name="economic_code" required>
                                                <option value="CAE 45" <?= $user_details['economic_code'] == "CAE 45" ? "selected" : "" ?>><?php echo get_phrase('CAE 45: Comércio, manutenção e reparação, de veículos automóveis e motociclos'); ?></option>
                                                <option value="CAE 46" <?= $user_details['economic_code'] == "CAE 46" ? "selected" : "" ?>><?php echo get_phrase('CAE 46: Comércio por grosso (inclui agentes), exceto de veículos automóveis e motociclos'); ?></option>
                                                <option value="CAE 47" <?= $user_details['economic_code'] == "CAE 47" ? "selected" : "" ?>><?php echo get_phrase('CAE 47: Comércio a retalho, exceto de veículos automóveis e motociclos;'); ?></option>
                                                <option value="CAE 56" <?= $user_details['economic_code'] == "CAE 56" ? "selected" : "" ?>><?php echo get_phrase('CAE 56: Restauração e similares'); ?></option>
                                                <option value="CAE 79" <?= $user_details['economic_code'] == "CAE 79" ? "selected" : "" ?>><?php echo get_phrase('CAE 79: Agências de Viagens, operadores turísticos, outros serviços de reservas e atividades relacionadas (com estabelecimento)'); ?></option>
                                                <option value="CAE 95" <?= $user_details['economic_code'] == "CAE 95" ? "selected" : "" ?>><?php echo get_phrase('CAE 95: Reparação de computadores e de bens de uso pessoal e doméstico'); ?></option>
                                                <option value="CAE 96" <?= $user_details['economic_code'] == "CAE 96" ? "selected" : "" ?>><?php echo get_phrase('CAE 96: Outras atividades de serviços pessoais.'); ?></option>
                                                <option value="Outro" <?= $user_details['economic_code'] == "Outro" ? "selected" : "" ?>><?php echo get_phrase('Outro'); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <?php if ($user_details['is_instructor'] > 0) : ?>
                                            <div class="form-group mb-3">
                                                <label class="text-dark fw-600" for="Biography"><?php echo site_phrase('title'); ?></label>
                                                <textarea class="form-control bg-white-2 text-14px" name="title" placeholder="<?php echo site_phrase('short_title_about_yourself'); ?>"><?php echo $user_details['title']; ?></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="text-dark fw-600" for="skills"><?php echo get_phrase('your_skills'); ?></label>
                                                <input type="text" class=" tagify" id="skills" name="skills" data-role="tagsinput" style="width: 100%;" value="<?php echo $user_details['skills'];  ?>" />
                                                <small class="text-muted"><?php echo get_phrase('write_your_skill_and_click_the_enter_button'); ?></small>
                                            </div>

                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label class="text-dark fw-600" for="Biography"><?php echo site_phrase('biography'); ?></label>
                                            <textarea class="form-control bg-white-2 text-14px text_editor" name="biography" id="Biography"><?php echo $user_details['biography']; ?></textarea>
                                        </div>

                                        <hr class="my-5 bg-secondary">

                                        <label class="text-dark fw-600"><?php echo site_phrase('add_your_twitter_link'); ?></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                            <input type="text" class="form-control bg-white-2 text-14px" maxlength="60" name="twitter_link" placeholder="<?php echo site_phrase('twitter_link'); ?>" value="<?php echo $social_links['twitter']; ?>">
                                        </div>


                                        <label class="text-dark fw-600"><?php echo site_phrase('add_your_facebook_link'); ?></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                            <input type="text" class="form-control bg-white-2 text-14px" maxlength="60" name="facebook_link" placeholder="<?php echo site_phrase('facebook_link'); ?>" value="<?php echo $social_links['facebook']; ?>">
                                        </div>


                                        <label class="text-dark fw-600"><?php echo site_phrase('add_your_linkedin_link'); ?></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                            <input type="text" class="form-control bg-white-2 text-14px" maxlength="60" name="linkedin_link" placeholder="<?php echo site_phrase('linkedin_link'); ?>" value="<?php echo $social_links['linkedin']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-12 pt-4">
                                        <button class="btn btn-primary px-5"><?php echo site_phrase('save'); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-------- wish list bosy section end ------->