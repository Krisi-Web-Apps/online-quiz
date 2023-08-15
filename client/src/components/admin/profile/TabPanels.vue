<template>
  <q-tabs v-model="tab" no-caps inline-label class="bg-grey-2 text-primary">
    <q-tab name="settings" icon="settings" :label="$t('settings')" />
  </q-tabs>
  <q-tab-panels v-model="tab" animated>
    <q-tab-panel name="settings">
      <profile-settings />
    </q-tab-panel>
  </q-tab-panels>
</template>

<script>
import { ref } from "vue";

import ProfileSettings from "src/components/admin/profile/ProfileSettings.vue";

export default {
  components: {
    ProfileSettings,
  },
  setup() {
    const tab = ref("settings");
    return { tab };
  },
};
</script>
