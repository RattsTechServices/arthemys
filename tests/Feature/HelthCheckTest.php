<?php

test('HelthCheck', function () {
    $response = $this->get('/up');
    $response->assertStatus(200);
});
