import tkinter as tk
from tkinter import filedialog
import cv2
import torch
from PIL import Image, ImageTk
from models.experimental import attempt_load
from utils.general import non_max_suppression, scale_coords
from utils.datasets import letterbox
import numpy as np

class YOLOv7VideoGUI:
    def __init__(self, root):
        self.root = root
        self.root.title("YOLOv7 Video Object Detection")
        self.root.geometry("960x720")
        self.root.columnconfigure(0, weight=1)
        self.root.rowconfigure(0, weight=1)

        self.main_frame = tk.Frame(root)
        self.main_frame.grid(sticky="nsew")
        self.main_frame.columnconfigure(0, weight=1)
        self.main_frame.rowconfigure(1, weight=1)

        self.canvas = tk.Label(self.main_frame)
        self.canvas.grid(row=0, column=0, columnspan=2, sticky="nsew")

        self.btn_frame = tk.Frame(self.main_frame)
        self.btn_frame.grid(row=1, column=0, sticky="ew", padx=10, pady=10)
        self.btn_frame.columnconfigure((0,1,2,3), weight=1)

        self.load_btn = tk.Button(self.btn_frame, text="Load Video", command=self.load_video)
        self.load_btn.grid(row=0, column=0, padx=5, sticky="ew")
        self.play_btn = tk.Button(self.btn_frame, text="Play", command=self.play_video)
        self.play_btn.grid(row=0, column=1, padx=5, sticky="ew")
        self.pause_btn = tk.Button(self.btn_frame, text="Pause", command=self.pause_video)
        self.pause_btn.grid(row=0, column=2, padx=5, sticky="ew")
        self.next_btn = tk.Button(self.btn_frame, text="Next Frame", command=self.next_frame)
        self.next_btn.grid(row=0, column=3, padx=5, sticky="ew")

        self.slider_frame = tk.Frame(self.main_frame)
        self.slider_frame.grid(row=2, column=0, sticky="ew", padx=10)
        self.slider_frame.columnconfigure(0, weight=1)

        self.conf_slider = tk.Scale(self.slider_frame, from_=0.1, to=1.0, resolution=0.05, orient=tk.HORIZONTAL, label="Confidence Threshold")
        self.conf_slider.set(0.25)
        self.conf_slider.grid(row=0, column=0, sticky="ew")

        self.log_label = tk.Label(self.main_frame, text="Detection Log", anchor='nw', justify='left', bg="white", relief="sunken")
        self.log_label.grid(row=0, column=1, rowspan=3, sticky="nsew", padx=10, pady=10)

        self.model = attempt_load("yolov7.pt", map_location='cpu')
        self.names = self.model.module.names if hasattr(self.model, 'module') else self.model.names
        self.running = False
        self.cap = None

    def load_video(self):
        video_path = filedialog.askopenfilename(filetypes=[("Video files", "*.mp4 *.mov *.avi")])
        if video_path:
            self.cap = cv2.VideoCapture(video_path)
            self.running = False
            # Re-enable buttons in case they were hidden
            self.load_btn.config(state="normal")
            self.play_btn.config(state="normal")
            self.pause_btn.config(state="normal")
            self.next_btn.config(state="normal")
            self.conf_slider.config(state="normal")
            self.next_frame()

    def preprocess(self, frame):
        img = letterbox(frame, new_shape=640)[0]
        img = img[:, :, ::-1].transpose(2, 0, 1)
        img = np.ascontiguousarray(img)
        img = torch.from_numpy(img).float()
        img /= 255.0
        return img.unsqueeze(0), frame

    def detect(self, frame):
        img, original = self.preprocess(frame)
        conf_thres = self.conf_slider.get()
        with torch.no_grad():
            pred = self.model(img)[0]
            pred = non_max_suppression(pred, conf_thres, 0.45, agnostic=False)

        log_text = []
        for det in pred:
            if det is not None and len(det):
                det[:, :4] = scale_coords(img.shape[2:], det[:, :4], original.shape).round()
                for *xyxy, conf, cls in reversed(det):
                    label = f'{self.names[int(cls)]} {conf:.2f}'
                    log_text.append(label)
                    xyxy = [int(x.item()) for x in xyxy]
                    cv2.rectangle(original, (xyxy[0], xyxy[1]), (xyxy[2], xyxy[3]), (0, 255, 0), 2)
                    cv2.putText(original, label, (xyxy[0], xyxy[1]-10), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (255,255,255), 1)
        return original, log_text

    def update_frame(self):
        if self.cap and self.running:
            ret, frame = self.cap.read()
            if ret:
                result, log = self.detect(frame)
                self.show_frame(result)
                self.log_label.config(text="\n".join(log))
                self.root.after(30, self.update_frame)
            else:
                self.cap.release()
                self.running = False

    def next_frame(self):
        if self.cap:
            ret, frame = self.cap.read()
            if ret:
                result, log = self.detect(frame)
                self.show_frame(result)
                self.log_label.config(text="\n".join(log))

    def play_video(self):
        self.running = True
        self.update_frame()

    def pause_video(self):
        self.running = False

    def show_frame(self, frame):
        frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        img = Image.fromarray(frame)
        imgtk = ImageTk.PhotoImage(image=img)
        self.canvas.imgtk = imgtk
        self.canvas.config(image=imgtk)

if __name__ == '__main__':
    root = tk.Tk()
    app = YOLOv7VideoGUI(root)
    root.mainloop()
