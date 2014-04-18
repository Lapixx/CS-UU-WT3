<?php
    if ($failed) {
        echo '<p>Invalid email or password.</p>';
    }

    echo form_open('login');

    $table = $this->table->make_columns(array(
            form_label('Email:', 'email'),
            form_input(array('name' => 'email', 'id' => 'email', 'value' => set_value('email'))),
            form_error('email'),

            form_label('Password:', 'password'),
            form_password(array('name' => 'password', 'id' => 'password', 'value' => set_value('password'))),
            form_error('password')
        ),
    3);

    echo $this->table->generate($table);

    echo form_submit('login', 'Log in');
    echo ' or ' . anchor('register', 'Register');
    echo form_close();