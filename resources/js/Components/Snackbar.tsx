import React, { useState, useEffect } from 'react';

type SnackbarProps = {
  message: string;
  duration?: number;
  type?: 'success' | 'error' | 'info';
  onClose?: () => void;
};

const Snackbar: React.FC<SnackbarProps> = ({ message, duration = 3000, type = 'info', onClose }) => {
  const [isVisible, setIsVisible] = useState(true);

  useEffect(() => {
    const timer = setTimeout(() => {
      setIsVisible(false);
      if (onClose) {
        onClose();
      }
    }, duration);

    return () => clearTimeout(timer);
  }, [duration, onClose]);

  if (!isVisible) return null;

  let bgColor = 'bg-blue-500';
  if (type === 'success') bgColor = 'bg-green-500';
  if (type === 'error') bgColor = 'bg-red-500';

  return (
    <div className={`fixed top-4 right-4 z-50 flex items-center justify-between px-4 py-2 text-white rounded-md shadow-lg ${bgColor}`}>
      <span>{message}</span>
      <button onClick={() => setIsVisible(false)} className="ml-4 text-white focus:outline-none">
        ✕
      </button>
    </div>
  );
};

export default Snackbar;