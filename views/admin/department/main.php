<div class="tkt-departents wrap nosubsub">

    <h1 class="wp-heading-inline">دپارتمان ها</h1>

    <hr class="wp-header-end">

    <div id="ajax-response"></div>

    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">

                <div class="form-wrap">
                    <h2>دپارتمان جدید</h2>
                    <form id="tkt-add-department" method="post" class="validate">
                        <?php wp_nonce_field('add_department', 'add_department_nonce', false); ?>
                        <div class="form-field form-required term-name-wrap">
                            <label for="department-name">عنوان</label>
                            <input name="name" id="department-name" type="text" value="" size="40" aria-required="true" aria-describedby="name-description" />
                        </div>
                        <div class="form-field term-parent-wrap">
                            <label for="parent">والد</label>
                            <select name='parent' id='department-parent' class='postform' aria-describedby="parent-description">
                                <option value="0">بدون والد</option>
                                <?php if (count($departments)) : ?>
                                    <?php foreach ($departments as $department) : ?>
                                        <?php
                                        if ($department->parent) {
                                            continue;
                                        }
                                        ?>
                                        <option value="<?php echo esc_attr($department->ID) ?>"><?php echo esc_html($department->name); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="department-answerable">کاربران پاسخگو</label>
                            <select name="answerable[]" id="department-answerable" multiple>

                            </select>
                        </div>
                        <div class="form-field">
                            <label for="department-position">موقعیت</label>
                            <input type="number" class="small-text" name="position" id="department-postion"></input>
                        </div>
                        <div class="form-field term-description-wrap">
                            <label for="department-description">توضیح کوتاه</label>
                            <textarea name="description" id="department-description" rows="5" cols="40" aria-describedby="description-description"></textarea>
                        </div>

                        <p class="submit">
                            <input type="submit" name="submit" id="submit" class="button button-primary" value="افزودن" /> <span class="spinner"></span>
                        </p>
                    </form>
                </div>
            </div>
        </div><!-- /col-left -->

        <div id="col-right">
            <div class="col-wrap">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th scope="col" class="manage-column">عنوان</th>
                            <th scope="col" class="manage-column">والد</th>
                            <th scope="col" class="manage-column">کاربر پاسخگو</th>
                            <th scope="col" class="manage-column">موقعیت</th>
                        </tr>
                    </thead>
                    <tbody id="the-list">
                        <?php if (count($departments)) : ?>
                            <?php foreach ($departments as $department) : ?>
                                <tr>
                                    <td>
                                        <strong><?php echo esc_html($department->name) ?></strong>
                                        <br>
                                        <div class="row-actions">
                                            <span class="edit"><a href="">ویرایش</a></span>
                                            <span class="delete"><a href="">حذف</a></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($department->parent) {
                                            $parent = $this->get_department($department->parent);
                                            echo $parent ? $parent->name : '__';
                                        } else {
                                            echo '__';
                                        }
                                        ?>
                                    </td>
                                    <td></td>
                                    <td><?php echo esc_html($department->position); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col" class="manage-column">عنوان</th>
                            <th scope="col" class="manage-column">والد</th>
                            <th scope="col" class="manage-column">کاربر پاسخگو</th>
                            <th scope="col" class="manage-column">موقعیت</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div><!-- /col-right -->

    </div><!-- /col-container -->

</div><!-- /wrap -->