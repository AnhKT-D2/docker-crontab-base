import request from "@/utils/request";

export const signIn = data => {
  return request({
    url: "/sign-in",
    method: "post",
    data
  });
};

export const account = () => {
  return request({
    url: "/account",
    method: "get"
  });
};
