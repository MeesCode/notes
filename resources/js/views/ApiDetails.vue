<template>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">api token</div>

                <div class="card-body">
                    {{ $store.getters.getUser.api_token }}
                </div>
            </div>

        </div>
    </div>
</template>