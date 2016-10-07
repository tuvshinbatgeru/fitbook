<template>
    <div class="row">
      <ul class="dropdown menu" data-dropdown-menu v-foundation-dropdown-menu>
          <li class="is-dropdown-submenu-parent" style="background-color:#aecaec; border-radius:4px; font-size:12px;">
              <a style="color:#fff; font-weight:bold;">{{$t('date')}}</a>
              
              <ul class="menu" style="margin-top:10px; background-color:#F2F5F8; border-radius:4px;">
                <div class="arrow"></div>

                <li>
                    <a style="font-weight:bold; color: #3f4652">
                        {{$t('newest')}}
                    </a>
                </li>

                <li><a @click="setOrderBy('newest')" style="font-weight:bold; color: #3f4652">{{$t('newest')}}</a></li>
                <li><a @click="setOrderBy('oldest')">{{$t('oldest')}}</a></li>
                <li><a @click="setOrderBy('heart')">{{$t('heart')}}</a></li>
                <li><a @click="setOrderBy('price')">{{$t('price')}}</a></li>
                <li><a @click="setOrderBy('max')">{{$t('max')}}</a></li>
              </ul>
          </li>
      </ul>
  </div>
</template>

<script>

    export default {
        props : {
            orderBy : {
                required : true,
            },
            multiple : {
                default : false,
            },
            options : {},
            selected : {},
        },

        ready : function () {

        },

        methods : {

        }
    }
</script>

<style lang="scss">
</style>