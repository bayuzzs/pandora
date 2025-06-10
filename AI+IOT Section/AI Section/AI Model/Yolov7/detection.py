import argparse
import torch
import cv2
from models.experimental import attempt_load
from utils.datasets import LoadImages
from utils.general import non_max_suppression, scale_coords
from utils.torch_utils import select_device

def run(weights='yolov7.pt', source='0', conf_thres=0.25, iou_thres=0.45, device='', view_img=False):
    device = select_device(device)
    half = device.type != 'cpu'

    # Load model
    model = attempt_load(weights, map_location=device)
    model.eval()
    if half:
        model.half()

    # Load dulu satu frame untuk ambil ukuran asli
    dataset_tmp = LoadImages(source, img_size=640)
    try:
        path, img, im0s, vid_cap = next(iter(dataset_tmp))
    except StopIteration:
        print("[ERROR] Tidak dapat membaca frame dari source.")
        return
    height, width = im0s.shape[:2]

    # Reload dataset dengan ukuran asli frame agar letterbox resize tidak error
    dataset = LoadImages(source, img_size=max(height, width))

    # OpenCV window dengan ukuran bisa diubah
    window_name = 'YOLOv7 Detection (q=quit, p=pause/resume)'
    cv2.namedWindow(window_name, cv2.WINDOW_NORMAL)

    paused = False

    for path, img, im0s, vid_cap in dataset:
        while paused:
            key = cv2.waitKey(100) & 0xFF
            if key == ord('p'):
                paused = not paused
            elif key == ord('q'):
                cv2.destroyAllWindows()
                return

        img = torch.from_numpy(img).to(device)
        img = img.half() if half else img.float()
        img /= 255.0
        if img.ndimension() == 3:
            img = img.unsqueeze(0)

        # Forward pass
        pred_raw = model(img)[0]

        # NMS
        pred = non_max_suppression(pred_raw, conf_thres, iou_thres)

        im0 = im0s.copy()  # asli tanpa resize

        print(f'\n LOG OBJECT DETECTION: {path}')
        if pred[0] is not None and len(pred[0]):
            pred[0][:, :4] = scale_coords(img.shape[2:], pred[0][:, :4], im0.shape).round()
            for *xyxy, conf, cls in pred[0]:
                # gambar kotak dan label
                xyxy_int = [int(x.item()) for x in xyxy]
                conf_f = float(conf.item())
                cls_i = int(cls.item())
                print(f" - Object Class {cls_i} (conf: {conf_f:.2f}) at {xyxy_int}")
                cv2.rectangle(im0, (xyxy_int[0], xyxy_int[1]), (xyxy_int[2], xyxy_int[3]), (255, 0, 0), 2)
                cv2.putText(im0, f'{conf_f:.2f}', (xyxy_int[0], xyxy_int[1] - 10),
                            cv2.FONT_HERSHEY_SIMPLEX, 0.6, (255, 0, 0), 2)
        else:
            print(" - Tidak ada objek terdeteksi.")

        if view_img:
            cv2.imshow(window_name, im0)

            key = cv2.waitKey(1) & 0xFF
            if key == ord('q'):
                break
            elif key == ord('p'):
                paused = not paused

    cv2.destroyAllWindows()

if __name__ == '__main__':
    parser = argparse.ArgumentParser()
    parser.add_argument('--weights', nargs='+', type=str, default='yolov7.pt', help='model weights path')
    parser.add_argument('--source', type=str, default='0', help='source (file, dir, webcam)')
    parser.add_argument('--conf-thres', type=float, default=0.25, help='confidence threshold')
    parser.add_argument('--iou-thres', type=float, default=0.45, help='IOU threshold for NMS')
    parser.add_argument('--device', default='', help='cuda device, i.e. 0 or cpu')
    parser.add_argument('--view-img', action='store_true', help='display results')
    opt = parser.parse_args()

    run(weights=opt.weights,
        source=opt.source,
        conf_thres=opt.conf_thres,
        iou_thres=opt.iou_thres,
        device=opt.device,
        view_img=opt.view_img)
