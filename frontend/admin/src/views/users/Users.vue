<template>
  <CRow>
    <Spinner :is-active="isActive" />
    <CCol col="12" xl="12">
      <CCard>
        <CCardHeader>
          <div class="user-action">
            <div class="user-search">
              <CRow class="custom-row">
                <CCol>
                  <CInput
                    :label="$t('common.label.search')"
                    :placeholder="$t('users.label.key_search')"
                    v-model="searchData.userInfo"
                    @input="liveSearch"
                  />
                </CCol>
                <CSelect
                  :label="$t('users.label.role')"
                  :options="role"
                  :placeholder="$t('users.label.role_placeholder')"
                  @update:value="changeSearchRole"
                />
              </CRow>
              <div class="btn-search">
                <CButton @click="searchUser" color="primary">
                  {{ $t("users.button.search") }}
                </CButton>
              </div>
            </div>
            <div class="custom-paginate">
              <CSelect
                :label="$t('users.label.custom_paginate')"
                :options="recordPerPage"
                @update:value="changePaginate"
              />
            </div>
            <div class="wrapper-create">
              <router-link
                :to="{ name: 'users.create' }"
                class="btn btn-primary"
              >
                Create
              </router-link>
            </div>
          </div>
        </CCardHeader>
        <CCardBody>
          <CDataTable :items="users" :fields="fields" hover sorter>
            <template #index="{index}">
              <td>{{ ++index }}</td>
            </template>
            <template #role="data">
              <td>
                <p v-if="data.item.level === 0">
                  {{ $t("common.supper_admin") }}
                </p>
                <p v-else-if="data.item.level === 1">
                  {{ $t("common.manager") }}
                </p>
                <p v-else-if="data.item.level === 2">
                  {{ $t("common.member") }}
                </p>
              </td>
            </template>
            <template #avatar="data">
              <td>
                <img :src="driveUrlImage + data.item.path" class="c-avatar" />
              </td>
            </template>
            <template #status="data">
              <td>
                {{
                  data.item.is_active === 1
                    ? $t("common.active")
                    : $t("common.inactive")
                }}
              </td>
            </template>
            <template #action="data">
              <td class="action">
                <router-link
                  :to="{ path: '/users/' + data.item.id }"
                  class="btn btn-dark"
                >
                  {{ $t("users.button.edit") }}
                </router-link>
                <router-link
                  :to="{ path: '/users/' + data.item.id + '/detail' }"
                  class="btn btn-behance"
                >
                  {{ $t("users.button.detail") }}
                </router-link>
                <CButton
                  @click="deleteUser(data.item.id)"
                  class="btn btn-dribbble"
                >
                  {{ $t("users.button.delete") }}
                </CButton>
              </td>
            </template>
          </CDataTable>
          <CPagination
            :activePage.sync="searchData.page"
            :pages="searchData.total"
            size="sm"
            align="center"
            @update:activePage="changePage"
          />
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import {
  CUSTOM_PAGINATE_DEFAULT,
  IS_MANAGER,
  IS_MEMBER,
  PAGE_DEFAULT,
  PER_PAGE_DEFAULT,
  IS_SUPPER_ADMIN,
  DRIVE_URL_IMAGE
} from "@/commons/constant";
import { mapGetters } from "vuex";
import _ from "lodash";
import Spinner from "@/components/Spinner";

export default {
  name: "Users",
  components: { Spinner },
  data() {
    return {
      fields: [
        { key: "index", label: this.$t("common.index") },
        {
          key: "name",
          label: this.$i18n.t("users.label.name"),
          _classes: "font-weight-bold"
        },
        { key: "email" },
        { key: "phone", label: this.$i18n.t("users.label.phone") },
        { key: "avatar", label: this.$i18n.t("users.label.avatar") },
        { key: "role", label: this.$i18n.t("users.label.role") },
        { key: "status", label: this.$i18n.t("users.label.status") },
        { key: "action", label: "Action" }
      ],
      recordPerPage: CUSTOM_PAGINATE_DEFAULT,
      role: [
        { value: "", label: "none" },
        { value: IS_SUPPER_ADMIN, label: this.$t("common.supper_admin") },
        { value: IS_MANAGER, label: this.$t("common.manager") },
        { value: IS_MEMBER, label: this.$t("common.member") }
      ],
      searchData: {
        userInfo: null,
        level: -1,
        perPage: PER_PAGE_DEFAULT,
        page: PAGE_DEFAULT,
        total: 0
      },
      debounceInput: null,
      driveUrlImage: DRIVE_URL_IMAGE,
      isActive: false
    };
  },
  created() {
    this.getUsers();
    this.debounceInput = _.debounce(function() {
      this.getUsers();
    }, 1000);
  },
  watch: {
    $route: {
      immediate: true,
      handler(route) {
        if (route.query && route.query.page) {
          this.activePage = Number(route.query.page);
        }
      }
    }
  },
  computed: {
    ...mapGetters({
      users: "user/users"
    })
  },
  methods: {
    async getUsers() {
      this.isActive = true;
      await this.$store
        .dispatch("user/getUsers", this.searchData)
        .then(response => {
          this.searchData.page = response.data.current_page;
          this.searchData.total = response.data.last_page;
          this.pageChange(response.data.current_page);
          this.isActive = false;
        });
    },
    async deleteUser(id) {
      this.isActive = true;
      await this.$store.dispatch("user/deleteUser", id).then(() => {
        this.$toast.success("ok", { position: "top-right" });
        this.isActive = false;
        this.getUsers();
      });
    },
    liveSearch() {
      this.debounceInput();
    },
    changeSearchRole(level) {
      this.searchData.level = level;
      this.getUsers();
    },
    searchUser() {
      this.getUsers();
    },
    changePage(page) {
      this.searchData.page = page;
      this.getUsers();
    },
    changePaginate(perPage) {
      this.searchData.perPage = perPage;
      this.getUsers();
    },
    pageChange(val) {
      this.$router.push({ query: { page: val } }, () => {});
    }
  }
};
</script>

<style lang="scss" scoped>
.user-action {
  display: flex;
}

.user-action > div {
  width: 33%;
  padding: 5px 30px;
  margin: 0 5px;
  box-shadow: 0 0 1px #718096;
}

.btn-search {
  text-align: center;
}

.wrapper-create {
  text-align: center;
  a {
    margin-top: 30px;
    display: inline-block;
  }
}

.action > * {
  margin: 0 2px;
}
</style>
