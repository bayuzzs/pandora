import torch
import cv2
import numpy as np
from flask import Flask, jsonify, Response
from threading import Thread, Lock
from models.experimental import attempt_load
from utils.general import non_max_suppression, scale_coords
from utils.datasets import letterbox

app = Flask(__name__)
jumlah_domba = 0
jumlah_domba_lock = Lock()

# Ganti URL stream sesuai IP
stream_url = 'http://10.10.1.99:5000/video_feed'
cap = cv2.VideoCapture(stream_url)

# Load YOLOv7 model
device = torch.device('cpu')
model = attempt_load('yolov7.pt', map_location=device)
model.eval()
names = model.module.names if hasattr(model, 'module') else model.names

def deteksi_domba():
    global jumlah_domba
    while True:
        success, frame = cap.read()
        if not success:
            continue

        img0 = frame.copy()
        img = letterbox(img0, new_shape=640)[0]
        img = img[:, :, ::-1].transpose(2, 0, 1)
        img = np.ascontiguousarray(img)

        img = torch.from_numpy(img).to(device).float() / 255.0
        if img.ndimension() == 3:
            img = img.unsqueeze(0)

        with torch.no_grad():
            pred = model(img)[0]
            pred = non_max_suppression(pred, conf_thres=0.4, iou_thres=0.45)

        temp_jumlah = 0
        for det in pred:
            if len(det):
                det[:, :4] = scale_coords(img.shape[2:], det[:, :4], img0.shape).round()
                for *xyxy, conf, cls in det:
                    if names[int(cls)].lower() == "sheep":
                        temp_jumlah += 1

        with jumlah_domba_lock:
            jumlah_domba = temp_jumlah

@app.route("/jumlah_domba", methods=["GET"])
def get_jumlah_domba():
    with jumlah_domba_lock:
        return jsonify({"jumlah_domba": jumlah_domba})

@app.route("/")
def index():
    return "API Deteksi Domba Aktif. Gunakan endpoint /jumlah_domba untuk melihat hasil."

if __name__ == "__main__":
    # Jalankan deteksi di thread terpisah agar Flask tetap responsif
    t = Thread(target=deteksi_domba, daemon=True)
    t.start()

    # Jalankan Flask server
    app.run(host="0.0.0.0", port=5001, debug=False)
