import request from "@/utils/request";

export const saveToken = data => {
  return request({
    url: "/notifications/save-device-token",
    method: "post",
    data
  });
};
