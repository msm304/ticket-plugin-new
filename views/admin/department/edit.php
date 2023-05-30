<div class="tkt-departents wrap nosubsub">

    <h1 class="wp-heading-inline">ویرایش دپارتمان ها</h1>

    <hr class="wp-header-end">

    <div id="ajax-response"></div>

    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">

                <div class="form-wrap">
                    <?php TKT_Flash_Message::show_message(); ?>
                    <form id="tkt-add-department" method="post" class="validate">
                        <?php wp_nonce_field('update_department', 'update_department_nonce', false); ?>
                        <input type="hidden" name="department_id" value="<?php echo esc_attr($department->ID) ?>">
                        <div class="form-field form-required term-name-wrap">
                            <label for="department-name">عنوان</label>
                            <input name="name" id="department-name" type="text" value="<?php echo esc_attr($department->name) ?>" size="40" aria-required="true" aria-describedby="name-description" />
                        </div>
                        <div class="form-field term-parent-wrap">
                            <label for="parent">والد</label>
                            <select name='parent' id='department-parent' class='postform' aria-describedby="parent-description">
                                <option value="0">بدون والد</option>
                                <?php if (count($departments)) : ?>
                                    <?php foreach ($departments as $item) : ?>
                                        <?php
                                        if ($item->parent || $item->ID == $department->ID) {
                                            continue;
                                        }
                                        ?>
                                        <option <?php echo $department->parent == $item->ID ? 'selected' : '' ?> value="<?php echo esc_attr($item->ID) ?>"><?php echo esc_html($item->name); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="department-answerable">کاربران پاسخگو</label>
                            <select name="answerable[]" id="department-answerable" multiple>

                                <?php
                                if (count($answerable)) {
                                    foreach ($answerable as $user_id) {
                                        $user_data = get_userdata($user_id);
                                        echo '<option value="' . $user_id . '"selected>' . $user_data->user_login . '</option>';
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-field">
                            <label for="department-position">موقعیت</label>
                            <input type="number" class="small-text" name="position" id="department-postion" value="<?php echo esc_attr($department->position) ?>"></input>
                        </div>
                        <div class="form-field term-description-wrap">
                            <label for="department-description">توضیح کوتاه</label>
                            <textarea name="description" id="department-description" rows="5" cols="40" aria-describedby="description-description"><?php echo esc_textarea($department->description) ?></textarea>
                        </div>

                        <p class="submit">
                            <input type="submit" name="submit" id="submit" class="button button-primary" value="ویرایش" /> <span class="spinner"></span>
                        </p>
                    </form>
                </div>
            </div>
        </div><!-- /col-left -->

    </div><!-- /col-container -->

</div><!-- /wrap -->