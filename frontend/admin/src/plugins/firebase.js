import firebase from "firebase";
const firebaseConfig = {
  apiKey: "AIzaSyDFWcGGxmXbNearyx8qO-LjmHPAeG7Hv-U",
  authDomain: "send-notification-a2a5e.firebaseapp.com",
  projectId: "send-notification-a2a5e",
  storageBucket: "send-notification-a2a5e.appspot.com",
  messagingSenderId: "207432167226",
  appId: "1:207432167226:web:c91e91cb8d16052e25aa03",
  measurementId: "G-9K98CB4FFV"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();

export default firebase;
